<?php

/**
 * Example Usage of Country-State-City Models with Referential Integrity
 * 
 * This file demonstrates how to use the models with safe delete functionality
 */

use App\Models\Country;
use App\Models\State;
use App\Models\City;

// Example 1: Safe Delete - Will fail if there are related records
function exampleSafeDelete()
{
    $country = Country::find(1);
    $result = $country->safeDelete();
    
    if ($result['success']) {
        echo "Country deleted successfully!";
    } else {
        echo "Cannot delete: " . $result['message'];
        echo "Related data: " . json_encode($result['related_data']);
    }
}

// Example 2: Check relationships before attempting delete
function exampleCheckRelationships()
{
    $country = Country::find(1);
    
    // Get detailed information about related data
    $relatedInfo = $country->getRelatedDataInfo();
    
    if (empty($relatedInfo)) {
        echo "Safe to delete - no related data found";
        $result = $country->safeDelete();
    } else {
        echo "Related data found:";
        foreach ($relatedInfo as $relationship => $info) {
            echo "- {$relationship}: {$info['count']} records";
        }
        
        // Ask user if they want to force delete
        echo "Do you want to force delete with cascade? (y/n)";
        // In real application, get user input
        $forceDelete = true; // For example purposes
        
        if ($forceDelete) {
            $result = $country->cascadeDelete();
            echo "Cascade delete result: " . $result['message'];
        }
    }
}

// Example 3: Preview what would be deleted in cascade
function exampleCascadePreview()
{
    $country = Country::find(1);
    $preview = $country->getCascadeDeletePreview();
    
    echo "Cascade delete would affect:";
    echo "- Main record: {$preview['main_record']['model']} (ID: {$preview['main_record']['id']})";
    
    foreach ($preview['related_records'] as $relationship => $info) {
        echo "- {$relationship}: {$info['count']} {$info['model']} records";
    }
    
    echo "Total records to be deleted: {$preview['total_records_to_delete']}";
}

// Example 4: Bulk delete with referential integrity checks
function exampleBulkDelete()
{
    $countryIds = [1, 2, 3];
    $results = [];
    
    foreach ($countryIds as $countryId) {
        $country = Country::find($countryId);
        if ($country) {
            $result = $country->safeDelete();
            $results[] = array_merge($result, [
                'country_id' => $countryId,
                'country_name' => $country->name
            ]);
        }
    }
    
    // Summary
    $successful = array_filter($results, fn($r) => $r['success']);
    $failed = array_filter($results, fn($r) => !$r['success']);
    
    echo "Bulk delete summary:";
    echo "- Successful: " . count($successful);
    echo "- Failed: " . count($failed);
    
    foreach ($failed as $failure) {
        echo "- Failed to delete {$failure['country_name']}: {$failure['message']}";
    }
}

// Example 5: Using the trait methods directly
function exampleTraitMethods()
{
    $state = State::find(1);
    
    // Check if it can be deleted
    if ($state->canBeDeleted()) {
        echo "State can be safely deleted";
    } else {
        echo "State has related data";
    }
    
    // Check if it has related data
    if ($state->hasRelatedData()) {
        $relatedInfo = $state->getRelatedDataInfo();
        echo "Related data: " . json_encode($relatedInfo);
    }
    
    // Safe delete
    $result = $state->safeDelete();
    echo $result['message'];
}

// Example 6: Extending City model for specific use case
// If you have a User model that references cities, you would update the City model like this:

/*
In City.php, update the getReferentialIntegrityRelationships method:

protected function getReferentialIntegrityRelationships(): array
{
    return ['users', 'addresses', 'offices']; // Add your relationships here
}

And add the relationship methods:

public function users()
{
    return $this->hasMany(User::class);
}

public function addresses()
{
    return $this->hasMany(Address::class);
}

public function offices()
{
    return $this->hasMany(Office::class);
}
*/

function exampleCityWithUsers()
{
    $city = City::find(1);
    
    // This will now check for users, addresses, and offices before allowing deletion
    $result = $city->safeDelete();
    
    if (!$result['success']) {
        echo "Cannot delete city: " . $result['message'];
        echo "Related data: " . json_encode($result['related_data']);
    }
}

// Example 7: Custom business logic
class CustomCountry extends Country
{
    /**
     * Override the canBeDeleted method for custom business logic
     */
    public function canBeDeleted(): bool
    {
        // Custom business rule: Cannot delete if it's a default country
        if ($this->code === 'US' || $this->code === 'CA') {
            return false;
        }
        
        // Use the standard referential integrity check
        return parent::canBeDeleted();
    }
    
    /**
     * Override safeDelete to include custom business logic
     */
    public function safeDelete(): array
    {
        // Check custom business rules first
        if ($this->code === 'US' || $this->code === 'CA') {
            return [
                'success' => false,
                'message' => 'Cannot delete default countries (US, CA).',
                'reason' => 'business_rule'
            ];
        }
        
        // Use the trait's safe delete method
        return parent::safeDelete();
    }
}