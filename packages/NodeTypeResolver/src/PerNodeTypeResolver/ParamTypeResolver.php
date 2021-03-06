<?php

declare(strict_types=1);

namespace Rector\NodeTypeResolver\PerNodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Identifier;
use PhpParser\Node\Param;
use PhpParser\NodeTraverser;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeTypeResolver\Contract\PerNodeTypeResolver\PerNodeTypeResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\PhpParser\Node\Resolver\NameResolver;
use Rector\PhpParser\NodeTraverser\CallableNodeTraverser;

/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ParamTypeResolver\ParamTypeResolverTest
 */
final class ParamTypeResolver implements PerNodeTypeResolverInterface
{
    /**
     * @var NameResolver
     */
    private $nameResolver;

    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;

    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;

    public function __construct(NameResolver $nameResolver, CallableNodeTraverser $callableNodeTraverser)
    {
        $this->nameResolver = $nameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }

    /**
     * @required
     */
    public function autowirePropertyTypeResolver(NodeTypeResolver $nodeTypeResolver): void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }

    /**
     * @return string[]
     */
    public function getNodeClasses(): array
    {
        return [Param::class];
    }

    /**
     * @param Param $node
     */
    public function resolve(Node $node): Type
    {
        $paramType = $this->resolveFromType($node);
        if (! $paramType instanceof MixedType) {
            return $paramType;
        }

        $firstVariableUseType = $this->resolveFromFirstVariableUse($node);
        if (! $firstVariableUseType instanceof MixedType) {
            return $firstVariableUseType;
        }

        return $this->resolveFromFunctionDocBlock($node);
    }

    private function resolveFromType(Node $node)
    {
        if ($node->type !== null && ! $node->type instanceof Identifier) {
            $resolveTypeName = $this->nameResolver->getName($node->type);
            if ($resolveTypeName) {
                // @todo map the other way every type :)
                return new ObjectType($resolveTypeName);
            }
        }

        return new MixedType();
    }

    private function resolveFromFirstVariableUse(Param $param): Type
    {
        $classMethod = $param->getAttribute(AttributeKey::METHOD_NODE);
        if ($classMethod === null) {
            return new MixedType();
        }

        /** @var string $paramName */
        $paramName = $this->nameResolver->getName($param);
        $paramStaticType = new MixedType();

        // special case for param inside method/function
        $this->callableNodeTraverser->traverseNodesWithCallable(
            (array) $classMethod->stmts,
            function (Node $node) use ($paramName, &$paramStaticType): ?int {
                if (! $node instanceof Variable) {
                    return null;
                }

                if (! $this->nameResolver->isName($node, $paramName)) {
                    return null;
                }

                $paramStaticType = $this->nodeTypeResolver->resolve($node);

                return NodeTraverser::STOP_TRAVERSAL;
            }
        );

        return $paramStaticType;
    }

    private function resolveFromFunctionDocBlock(Param $param): Type
    {
        /** @var FunctionLike $parentNode */
        $parentNode = $param->getAttribute(AttributeKey::PARENT_NODE);

        /** @var string $paramName */
        $paramName = $this->nameResolver->getName($param);

        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $parentNode->getAttribute(AttributeKey::PHP_DOC_INFO);

        return $phpDocInfo->getParamType($paramName);
    }
}
