<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Carbon\Carbon;
use App\Cards;
use App\Company;
use Illuminate\Support\Facades\Http;
class NationalCampany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campany:national';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
                 /////////////dubi national api
                 $balancenational = Http::withHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ])->post('https://taxes.like4app.com/online/check_balance/', [
                    'deviceId' => '4d2ec47930a1fe0706836fdd1157a8c320dfc962aa6d0b0df2f4dda40a27b2ba',
                    'email' => 'sales@bn-plus.ly',
                    'password' => '149e7a5dcc2b1946ebf09f6c7684ab2c',
                    'securityCode' => '4d2ec47930a1fe0706836fdd1157a8c36bd079faa0810ff7562c924a23c3f415',
                    'langId' => 1,
                ]);
                if (isset($balancenational) && !empty($balancenational) && $balancenational!='error code: 1020') {
                   // return $balancenational;
                    if ($balancenational->balance > 0) {


                        $nationalApicompany = Http::withHeaders([
                            'Content-Type' => 'application/x-www-form-urlencoded'
                        ])->post('https://taxes.like4app.com/online/categories', [
                            'deviceId' => '4d2ec47930a1fe0706836fdd1157a8c320dfc962aa6d0b0df2f4dda40a27b2ba',
                            'email' => 'sales@bn-plus.ly',
                            'password' => '149e7a5dcc2b1946ebf09f6c7684ab2c',
                            'securityCode' => '4d2ec47930a1fe0706836fdd1157a8c36bd079faa0810ff7562c924a23c3f415',
                            'langId' => 1,
                        ]);

                        if (isset($nationalApicompany['data']) && !empty($nationalApicompany['data']) && $nationalApicompany!='error code: 1020') {
                            foreach($nationalApicompany['data'] as $company){
                                $company_data['id']=$company['id'];
                                $company_data['name']=$company['categoryName'];
                                $company_data['company_image']=$company['amazonImage'];
                                $company_data['api']=1;
                                $company_data['kind']='national';
                                
                                Company::create($company_data);
                            }

                        }



                        $nationalApicrds = Http::withHeaders([
                            'Content-Type' => 'application/x-www-form-urlencoded'
                        ])->post('https://taxes.like4app.com/online/products', [
                            'deviceId' => '4d2ec47930a1fe0706836fdd1157a8c320dfc962aa6d0b0df2f4dda40a27b2ba',
                            'email' => 'sales@bn-plus.ly',
                            'password' => '149e7a5dcc2b1946ebf09f6c7684ab2c',
                            'securityCode' => '4d2ec47930a1fe0706836fdd1157a8c36bd079faa0810ff7562c924a23c3f415',
                            'langId' => 1,
    
                        ]);



                        if (isset($nationalApicrds['data']) && !empty($nationalApicrds['data']) && $nationalApicrds!='error code: 1020') {
                            foreach($nationalApicrds['data'] as $card){
                                $card_data['id']=$card['productId'];
                                $card_data['company_id']=$card['categoryId'];
                                $card_data['card_name']=$card['productName'];
                                $card_data['nationalcompany']='national';
                                $card_data['card_price']=$card['productPrice'];
                                $card_data['card_code']=$card['productName'];
                                $card_data['card_image']=$card['productImage'];
                                $card_data['api']=1;
                               
                                
                                Cards::create($card_data);
                            }

                        }



                    }
                    $this->info('National Cummand Run successfully!.');
                }
    }
}
