<?php

namespace App\Traits;

use App\Models\CustomField;
use App\Models\CustomFieldValue;
use Illuminate\Support\Facades\Auth;

trait HasCustomFields
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function fields()
    {
        return $this->morphMany(CustomFieldValue::class, 'custom_field_valuable');
    }

    /**
     * @return \App\Models\CustomField
     */
    public function getCustomFields()
    {
        $currentCompany = Auth::user()->currentCompany();
        return CustomField::findByCompany($currentCompany->id)->whereType($this->getMorphClass())->orderBy('order', 'asc')->get();
    }

    /**
     * @return any
     */
    public function getDefaultCustomFieldValue($custom_field_id)
    {
        $customField = CustomField::find($custom_field_id);

        return $customField 
            ? $customField->default_answer 
            : null;
    }

    /**
     * @return any
     */
    public function getCustomFieldValue($custom_field_id)
    {
        $customField = $this->fields()->where('custom_field_id', $custom_field_id)->first();

        return $customField 
            ? $customField->default_answer 
            : $this->getDefaultCustomFieldValue($custom_field_id);
    }

    /**
     * Add Custom Field Values for the Model
     *
     * @return void
     */
    public function addCustomFields($customFields)
    {
        if (is_array($customFields)) { 
            foreach ($customFields as $uid => $value) {
                $customField = CustomField::findByUid($uid);
    
                $customFieldValue = [
                    'type' => $customField->type,
                    'custom_field_id' => $customField->id,
                    'company_id' => $customField->company_id,
                    get_custom_field_value_key($customField->type) => $value
                ];
    
                $this->fields()->create($customFieldValue);
            }
        }
    }

    /**
     * Update Existing Custom Field Values for the Model
     *
     * @return void
     */
    public function updateCustomFields($customFields)
    {
        if (is_array($customFields)) {
            foreach ($customFields as $uid => $value) {
                $customField = CustomField::findByUid($uid);
    
                $customFieldValue = $this->fields()->firstOrCreate([
                    'custom_field_id' => $customField->id,
                    'type' => $customField->type,
                    'company_id' => $this->company_id
                ]);
    
                $type = get_custom_field_value_key($customField->type);
                $customFieldValue->$type = $value;
                $customFieldValue->save();
            }
        } 
    }
}
