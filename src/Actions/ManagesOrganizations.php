<?php

declare(strict_types=1);

namespace Ugarit\Forge\Actions;

use Ugarit\Forge\CursorPaginator;
use Ugarit\Forge\Resources\Organization;
use Ugarit\Forge\Resources\ServerCredential;
use Ugarit\Forge\Resources\VPC;

trait ManagesOrganizations
{
    /**
     * Get the collection of organizations.
     */
    public function organizations(array $query = []): CursorPaginator
    {
        return $this->paginatedCollection(
            'orgs',
            Organization::class,
            query: $query,
        );
    }

    /**
     * Get a specific organization.
     */
    public function organization(string $organizationSlug): Organization
    {
        return new Organization($this->get("orgs/{$organizationSlug}")['data'] ?? [], $this);
    }

    /**
     * Get the collection of server credentials for an organization.
     */
    public function serverCredentials(string $organizationSlug, array $query = []): CursorPaginator
    {
        return $this->paginatedCollection(
            "orgs/{$organizationSlug}/server-credentials",
            ServerCredential::class,
            $organizationSlug,
            query: $query,
        );
    }

    /**
     * Get a specific server credential.
     */
    public function serverCredential(string $organizationSlug, int $credentialId): ServerCredential
    {
        return $this->newResource(
            ServerCredential::class,
            $this->get("orgs/{$organizationSlug}/server-credentials/{$credentialId}")['data'] ?? [],
            $organizationSlug,
        );
    }

    /**
     * Create a new VPC.
     */
    public function createVpc(string $organizationSlug, int $credentialId, string $region, array $data = []): VPC
    {
        return $this->newResource(
            VPC::class,
            $this->post(
                "orgs/{$organizationSlug}/server-credentials/{$credentialId}/regions/{$region}/vpcs",
                $data
            )['data'] ?? [],
            $organizationSlug,
            extra: ['credential_id' => $credentialId, 'region' => $region],
        );
    }

    /**
     * Get the collection of VPCs.
     */
    public function vpcs(string $organizationSlug, int $credentialId, string $region, array $query = []): CursorPaginator
    {
        return $this->paginatedCollection(
            "orgs/{$organizationSlug}/server-credentials/{$credentialId}/regions/{$region}/vpcs",
            VPC::class,
            $organizationSlug,
            extra: ['credential_id' => $credentialId, 'region' => $region],
            query: $query,
        );
    }

    /**
     * Get a specific VPC.
     */
    public function vpc(string $organizationSlug, int $credentialId, string $region, int $vpcId): VPC
    {
        return $this->newResource(
            VPC::class,
            $this->get("orgs/{$organizationSlug}/server-credentials/{$credentialId}/regions/{$region}/vpcs/{$vpcId}")['data'] ?? [],
            $organizationSlug,
            extra: ['credential_id' => $credentialId, 'region' => $region],
        );
    }
}
