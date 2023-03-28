<?php

namespace App\Http\Controllers\Admin\PromotionalsCodes;

use App\Http\Controllers\Controller;
use App\Models\BusinessType;
use App\Models\PromotionalCode;
use App\Models\PromotionalCodesSettings;
use App\Models\UserBusiness;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class PromotionalsCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotionals = PromotionalCode::when(request()->filled('search'),function($q){
          $q->where(function($q){
              $q->where('name','like','%'.request('search').'%');
          });
      })
      ->when(request()->filled('status'),function($q){
          $q->where('status',request('status'));
      })
      ->when(request()->filled('dateFrom') && request()->filled('dateTill'),function($q){
        $q->whereBetween('created_at',[request('dateFrom'),request('dateTill')]);
    })
      ->paginate(request('entries'));
      
      return response()->json(compact('promotionals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['promo_for' => $request->promo]);
        $id = PromotionalCode::create($request->all())->id;
        foreach ($request->selectedBusinessesType as $businessesType)
        {
            
            $businesses_type =  PromotionalCodesSettings::create(['promo_code_id' =>$id , 'promable_type' =>get_class(BusinessType::first()), 'promable_id' => $businessesType['id'] ]);
        }
        foreach ($request->selectedBusinesses as $businesses)
        {
            $businesses_type =  PromotionalCodesSettings::create(['promo_code_id' =>$id , 'promable_type' =>get_class(UserBusiness::first()), 'promable_id' => $businesses['id'] ]);
        }
        return  Response()->json(['status' =>true ,'msg' =>'Promo Code Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       $promotional = PromotionalCode::with(['business_details'])->find($id);
       $arr_business_type= array();
       $arr_business = array();
        if(count($promotional['business_details']) > 0)
       foreach ($promotional['business_details'] as $businesses)
       {
            
            if($businesses['promable_type'] == get_class(BusinessType::first()))
            {
                
                $arr_business_type[] = BusinessType::select('id','name' , 'status')->where('id',$businesses['promable_id'])->first();
            }
            else if($businesses['promable_type'] == get_class(UserBusiness::first()))
            {
                
                $arr_business[] = UserBusiness::select('id','business_name')->where('id',$businesses['promable_id'])->first();
            }
       }
       $promotional['business_types'] = $arr_business_type;
       $promotional['business_names'] = $arr_business;

       return response()->json(compact('promotional'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $input = $request->only(['name' ,'detail' ,'promo_for' ,'registration_percent' ,'no_of_smiles' ,'boosts_no_of_clicks' ,'no_of_report'  ,'promo_code' ,'starting_date' ,'expiry_date' ,'code_usability','code_usability_no_of_times','status']);
        $PromotionalCode = PromotionalCode::where('id' ,$id)->update(  $input );
        $res=PromotionalCodesSettings::where('promo_code_id',$id)->delete();   
        foreach ($request->selectedBusinessesType as $businessesType)
        {
            
            $businesses_type =  PromotionalCodesSettings::updateOrCreate(['promo_code_id' =>$id , 'promable_type' =>get_class(BusinessType::first()), 'promable_id' => $businessesType['id'] ]);
        }
        foreach ($request->selectedBusinesses as $businesses)
        {
            $businesses_type =  PromotionalCodesSettings::updateOrCreate(['promo_code_id' =>$id , 'promable_type' =>get_class(UserBusiness::first()), 'promable_id' => $businesses['id'] ]);
        }

        return  Response()->json(['status' =>true ,'msg' =>'Promo Code Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
