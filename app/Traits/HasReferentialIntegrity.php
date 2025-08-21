<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasReferentialIntegrity
{
    /**
     * Define the relationships that should be checked before deletion
     * Override this method in your model to specify which relationships to check
     */
    protected function getReferentialIntegrityRelationships(): array
    {
        return [];
    }

    /**
     * Check if the model has any related data that would prevent deletion
     */
    public function hasRelatedData(): bool
    {
        $relationships = $this->getReferentialIntegrityRelationships();
        
        foreach ($relationships as $relationship) {
            if (method_exists($this, $relationship)) {
                $relation = $this->$relationship();
                
                // Check if the relationship has any records
                if ($relation instanceof HasMany || $relation instanceof HasOne || $relation instanceof BelongsToMany) {
                    if ($relation->exists()) {
                        return true;
                    }
                }
            }
        }
        
        return false;
    }

    /**
     * Get detailed information about related data
     */
    public function getRelatedDataInfo(): array
    {
        $relationships = $this->getReferentialIntegrityRelationships();
        $info = [];
        
        foreach ($relationships as $relationship) {
            if (method_exists($this, $relationship)) {
                $relation = $this->$relationship();
                
                if ($relation instanceof HasMany || $relation instanceof HasOne || $relation instanceof BelongsToMany) {
                    $count = $relation->count();
                    if ($count > 0) {
                        $info[$relationship] = [
                            'count' => $count,
                            'model' => get_class($relation->getRelated())
                        ];
                    }
                }
            }
        }
        
        return $info;
    }

    /**
     * Safe delete with referential integrity check
     */
    public function safeDelete(): array
    {
        $relatedInfo = $this->getRelatedDataInfo();
        
        if (!empty($relatedInfo)) {
            $relationshipNames = array_keys($relatedInfo);
            $totalRelated = array_sum(array_column($relatedInfo, 'count'));
            
            return [
                'success' => false,
                'message' => 'Cannot delete record. It has related data in: ' . implode(', ', $relationshipNames),
                'related_data' => $relatedInfo,
                'total_related_records' => $totalRelated
            ];
        }

        // If no related data exists, proceed with deletion
        $this->delete();
        
        return [
            'success' => true,
            'message' => 'Record deleted successfully.'
        ];
    }

    /**
     * Force delete with cascade (override this method in your model for custom cascade logic)
     */
    public function cascadeDelete(): array
    {
        $relationships = $this->getReferentialIntegrityRelationships();
        $deletedCounts = [];
        
        foreach ($relationships as $relationship) {
            if (method_exists($this, $relationship)) {
                $relation = $this->$relationship();
                
                if ($relation instanceof HasMany) {
                    $count = $relation->count();
                    if ($count > 0) {
                        $relation->delete();
                        $deletedCounts[$relationship] = $count;
                    }
                }
            }
        }
        
        // Delete the main record
        $this->delete();
        
        return [
            'success' => true,
            'message' => 'Record and all related data deleted successfully.',
            'deleted_related' => $deletedCounts
        ];
    }

    /**
     * Check if deletion is allowed (can be overridden for custom business logic)
     */
    public function canBeDeleted(): bool
    {
        return !$this->hasRelatedData();
    }

    /**
     * Get a summary of what would be deleted in a cascade delete
     */
    public function getCascadeDeletePreview(): array
    {
        $relationships = $this->getReferentialIntegrityRelationships();
        $preview = [];
        
        foreach ($relationships as $relationship) {
            if (method_exists($this, $relationship)) {
                $relation = $this->$relationship();
                
                if ($relation instanceof HasMany) {
                    $count = $relation->count();
                    if ($count > 0) {
                        $preview[$relationship] = [
                            'count' => $count,
                            'model' => get_class($relation->getRelated()),
                            'will_be_deleted' => true
                        ];
                    }
                }
            }
        }
        
        return [
            'main_record' => [
                'model' => get_class($this),
                'id' => $this->getKey(),
                'will_be_deleted' => true
            ],
            'related_records' => $preview,
            'total_records_to_delete' => 1 + array_sum(array_column($preview, 'count'))
        ];
    }
}