<?php

declare(strict_types=1);

namespace Ugarit\Forge\Resources;

class Permission extends Resource
{
    /**
     * The id of the permission.
     */
    public ?int $id = null;

    /**
     * The name of the permission.
     */
    public ?string $name = null;
}
