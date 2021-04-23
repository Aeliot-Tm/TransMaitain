<?php

declare(strict_types=1);

namespace Aeliot\Bundle\TransMaintain\Model;

use LogicException;

final class Layer
{
    private const WEY_DOWN = 'down';
    private const WEY_UP = 'up';

    private ?bool $hasWayUp = null;
    private bool $isSameValue = true;
    private ?array $selectedNPoint = null;
    private ?array $selectedYPoint;
    private ?string $selectedKey = null;
    private ?self $parent;
    private string $way = self::WEY_UP;
    private ?array $yaml = null;

    public function __construct(self $parent = null)
    {
        $this->parent = $parent;
        if ($parent) {
            if (null === $parent->yaml) {
                throw new LogicException('Passed not initiated parent');
            }
            $this->selectedYPoint = $parent->yaml;
            $this->yaml = &$parent->yaml;
        }
    }

    public function &getYaml(): array
    {
        return $this->yaml;
    }

    public function setYaml(array &$yaml): void
    {
        $this->yaml = &$yaml;
    }

    public function getParent(): ?Layer
    {
        return $this->parent;
    }

    public function isSameValue(): bool
    {
        return $this->isSameValue;
    }

    public function setNotSameValue(): void
    {
        $this->isSameValue = false;
    }

    public function isUp(): bool
    {
        return self::WEY_UP === $this->way;
    }

    public function goDown(): void
    {
        $this->way = self::WEY_DOWN;
    }

    public function goUp(): void
    {
        $this->way = self::WEY_UP;
    }

    public function getSelectedKey(): ?string
    {
        return $this->selectedKey;
    }

    public function setSelectedKey(string $selectedKey): void
    {
        $this->selectedKey = $selectedKey;
    }

    public function &getSelectedNPoint(): ?array
    {

        return $this->selectedNPoint;
    }

    public function setSelectedNPoint(array &$selectedNPoint): void
    {
        $this->selectedNPoint = &$selectedNPoint;
    }

    public function &getSelectedYPoint(): ?array
    {
        return $this->selectedYPoint;
    }

    public function setSelectedYPoint(array &$selectedYPoint): void
    {
        $this->selectedYPoint = &$selectedYPoint;
    }

    public function setNoWayUp(): void
    {
        $this->hasWayUp = false;
    }

    public function setHasWayUp(): void
    {
        $this->hasWayUp = true;
    }

    public function hasWayUp(): bool
    {
        if (($hasWayUp = $this->hasWayUp) === null && $this->parent) {
            $hasWayUp = $this->parent->hasWayUp();
        }

        return is_bool($hasWayUp) ? $hasWayUp : true;
    }

    public function getResultKey(): string
    {
        $chain = $this->parent ? $this->parent->getKeyChain() : [];
        $chain[] = $this->selectedKey;

        return implode('.', $chain);
    }

    private function getKeyChain(): array
    {
        $chain = ($this->parent && !$this->parent->hasWayUp()) ? $this->parent->getKeyChain() : [];
        if (!$this->hasWayUp()) {
            $chain[] = $this->selectedKey;
        }

        return $chain;
    }
}