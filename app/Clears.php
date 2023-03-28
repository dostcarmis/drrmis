<?php

namespace App;

use App\Models\Municipality;
use App\Models\Province;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Clears extends Model
{
    protected $table = 'tbl_clears';
    protected $fillable = [
        'barangay_id',
        "municipality_id",
        "user_id",
        "survey_date",
        "survey_latitude",
        "survey_longitude",
        "vFactor",
        "fFactor",
        "frequency_id",
        "sRating",
        "material_id",
        "sRed",
        "dRed",
        "drain_id",
        "rain",
        "lFactor",
        "land_id",
        "alphaRating",
        "Fs",
        "image",
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function municipality(){
        return $this->belongsTo(Municipality::class);
    }
    public function province(){
        return $this->municipality->belongsTo(Province::class);
    }
    public function slopeAngle($rating = 0){
        $angle = "";
        switch($rating){
            case "100": $angle = "Slope angle greater than 75°"; break;
            case "32": $angle = "Slope angle greater than 60° but less than or equal to 75°"; break;
            case "17": $angle = "Slope angle greater than 45° but less than or equal to 60°"; break;
            case "10": $angle = "Slope angle greater than 30° but less than or equal to 45°"; break;
            case "5": $angle = "Slope angle greater than 15° but less than or equal to 30°"; break;
            case "2": $angle = "Slope angle less than or equal to 15°"; break;
            default: $angle = "This is an invalid rating"; break;
        }
        return $angle;
    }
    public function slopeMaterial($srating){
        $srating = strtoupper(trim($srating));
        $material = "";
        switch($srating){
            case "HR1": $material = "Massive and intact hard rock"; break;
            case "HR2": $material = "Blocky, well-interlocked hard rock, rock mass consisting mostly of cubical blocks"; break;
            case "HR3": $material = "Very blocky and fractured hard rock (disturbed with multifaceted angular blocks formed by 4 or more discontinuity sets) "; break;
            case "HR4": $material = "Disintegrated, unstable rocks and boulders, protruding rock fragments"; break;
            case "SR1": $material = "Massive and intact soft rock"; break;
            case "SR2": $material = "Very blocky and fractured soft rock "; break;
            case "HS1": $material = "Stiff, cemented and dense gravelly, sandy, silty and clayey soils"; break;
            case "SS1": $material = "Gravelly soil"; break;
            case "SS2": $material = "Sandy soil"; break;
            case "SS3": $material = "Clayey/silty soil"; break;
            default: $material = "This is an invalid rating"; break;
        }
        return $material;
    }
    public function vegetation($v){
        $vegetation = "";
        $v = number_format((float)$v,1);
        switch ($v){
            case "1.0": $vegetation = "No vegetation"; break;
            case "1.1": $vegetation = "Predominantly grass or vegetation with shallow roots"; break;
            case "1.2": $vegetation = "Coconut, bamboo or vegetation with moderately deep roots"; break;
            case "1.5": $vegetation = "Dense forests with trees of the same specie having age less than or equal to 20 years"; break;
            case "2.0": $vegetation = "Dense and mixed forests with trees having age less than or equal to 20 years or; Dense forests with pine trees having ages of more than 20 years"; break;
            case "2.5": $vegetation = "Dense and mixed forests with trees having ages of more than 20 years"; break;
            default: $vegetation = "This is an invalid rating"; break;
        }
        return $vegetation;
    }
    public function springs($s){
        $springs = "";
        switch($s){
            case "2": $springs = "Year-long"; break;
            case "1": $springs = "Only during rainy season"; break;
            case "0": $springs = "No flow/spring "; break;
            case "": $springs = "Empty value"; break;
            default: $springs = "This is an invalid rating"; break;
        }
        return $springs;
    }
    public function canals($s){
        $canals = "";
        switch($s){
            case "2": $canals = "No drainage system or; totally clogged, filled with debris"; break;
            case "1": $canals = "Partially clogged or overflows during heavy rains or; water leaks into the slope"; break;
            case "0": $canals = "Good working condition"; break;
            case "": $canals = "Empty value"; break;
            default: $canals = "This is an invalid rating"; break;
        }
        return $canals;
    }
    public function rain($s){
        $rain = "";
        switch($s){
            case "0": $rain = "50mm or less"; break;
            case "2": $rain = "More than 50mm but less than 100mm"; break;
            case "3": $rain = "More than 100mm but less than 200mm"; break;
            case "4": $rain = "More than 200mm"; break;
            case "": $rain = "Empty value"; break;
            default: $rain = "This is an invalid rating"; break;
        }
        return $rain;
    }
    public function land($l){
        $land = "";
        switch($l){
            case "1": $land = "Dense residential area (with closely spaced structures <5m)"; break;
            case "2": $land = "Commercial with building/s having 2 storeys or more"; break;
            case "3": $land = "Residential area with buildings having 2 storeys spaced at ≥5m"; break;
            case "4": $land = "Road/highway with heavy traffic (1 truck or more every 10mins)"; break;
            case "5": $land = "Road/highway with light traffic (less than 1 truck every 10mins)"; break;
            case "6": $land = "Agricultural area, grasslands and bushlands"; break;
            case "7": $land = "Forest"; break;
            case "8": $land = "Uninhabited and no vegetation"; break;
            default: $land = "This is an invalid rating"; break;
        }
        return $land;
    }
    public function frequency($f){
        $freq = "";
        switch($f){
            case "1": $freq = "Once a year or more than once a year"; break;
            case "2": $freq = "Presence of past failure, but occurrence not yearly"; break;
            case "3": $freq = "Presence of tensile cracks in ground"; break;
            case "4": $freq = "If with retaining wall, wall is deformed"; break;
            case "5": $freq = "None"; break;
            default: $freq = "This is an invalid rating"; break;
        }
        return $freq;
    }
    public function stability($s){
        $s = (float)$s;
        $stability = "";
        switch($s){
            case ($s >= 1.2): $stability = "Stable"; break;
            case ($s < 1.2 && $s >= 1): $stability = "Marginally stable"; break;
            case ($s < 1 && $s >= 0.7): $stability = "Susceptible"; break;
            case ($s < 0.7): $stability = "Highly susceptible"; break;
            default: $stability = "This is an invalid rating"; break;
        }
        return $stability;
    }
    public static function dirty($report,$req){
        $dirty=[];
        $base = $report->toArray();
        $base['survey_date'] = date('Y-m-d',strtotime($base['survey_date']));
        foreach($base as $k=>$v){
            if($req->has($k) && $base[$k] != $req->input($k)){
                $dirty[] = ['field'=>$k,'from'=>$v,'to'=>$req->input($k)];
            }
        }
        $res = '';
        for($i = 0; $i < count($dirty); $i++){
            $field = $dirty[$i]['field'];
            $from = $dirty[$i]['from'];
            $to = $dirty[$i]['to'];
            $res.="Changed $field from $from to $to.\n";
        }
        return $res;
    }
}
