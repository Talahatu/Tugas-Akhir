<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\FinancialHistory;
use App\Models\Image;
use App\Models\Order;
use App\Models\ProductStockHistory;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Shop::where("user_id", Auth::user()->id)->first();
        $stockHistories = ProductStockHistory::with(["product.images", "product.shop" => function ($query) use ($shop) {
            $query->where("id", $shop->id);
        }])->whereHas("product.shop", function ($query) use ($shop) {
            $query->where("id", $shop->id);
        })->orderBy("date", "DESC")
            ->get();
        return view('merchant.product', compact('shop', 'stockHistories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $exists = Shop::where("user_id", Auth::user()->id)->get();
        // if (count($exists) > 0) {
        //     return redirect()->route('seller.index');
        // }
        // return view('auth.register-seller');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreShopRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate(
        //     [
        //         'image' => 'required|image|mimes:jpg,png,jpeg|max:3096',
        //         'name' => 'required|string',
        //         'address' => 'required|string',
        //         'phoneNumber' => 'required'
        //     ],
        //     [
        //         "image.image" => "its not an image!",
        //         "image.max" => "Image size exceed 3MB!"
        //     ]
        // );
        // $latlong = explode(",", $request->get("latlng"));
        // $file = $request->file("image");
        // $ext = $file->getClientOriginalExtension();
        // $filename = "shop_" . time() . "." . $ext;
        // $path = public_path() . '/shopimages';
        // $file->move($path, $filename);

        // $newShop = "";
        // DB::transaction(function () use ($request, $latlong, $filename) {
        //     $newShop = new Shop();
        //     $newShop->user_id = Auth::user()->id;
        //     $newShop->name = $request->get("name");
        //     $newShop->phoneNumber = $request->get("phoneNumber");
        //     $newShop->address = $request->get("address");
        //     $newShop->lat = $latlong[0];
        //     $newShop->long = $latlong[1];
        //     $newShop->logoImage = $filename;
        //     $newShop->save();

        //     $user = User::find(Auth::user()->id);
        //     $user->type = "seller";
        //     $user->save();
        // });
        // return view('merchant.index', ["shop" => $newShop]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show($shop)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit($shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShopRequest  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy($shop)
    {
        //
    }

    public function showChat()
    {
        $shop = Shop::where("user_id", Auth::user()->id)->first();
        $allCustomerChats = Chat::with(["contents", "user"])
            ->where("shop_id", $shop->id)->get();
        return view('merchant.chat', compact("shop", "allCustomerChats"));
    }
    public function getSeller(Request $request)
    {
        return response()->json(["data" => Shop::find($request->get("id"))]);
    }

    public function showFinancials()
    {
        $shop = Shop::where("user_id", Auth::user()->id)->first();
        $thisMonthRevenue = Order::select(DB::raw('SUM(orders.total) as total'))
            ->where('shop_id', $shop->id)
            ->where('orderStatus', 'done')
            ->whereRaw('MONTH(orders.payment_release_date) = MONTH(CURRENT_DATE)')
            ->whereRaw('YEAR(orders.payment_release_date) = YEAR(CURRENT_DATE)')
            ->first()
            ->total;
        $allRevenue = Order::select(DB::raw('SUM(orders.total) as total'))
            ->where('shop_id', $shop->id)
            ->where('orderStatus', 'done')
            ->first()
            ->total;
        $financialHistories = FinancialHistory::where("shop_id", $shop->id)->orderBy("date", "DESC")->get();
        return view("merchant.financials", compact("shop", "thisMonthRevenue", "allRevenue", "financialHistories"));
    }

    public function productSold(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $shop = Shop::where("user_id", Auth::user()->id)->first();
            $order = Order::select(
                DB::raw('COUNT(orders.id) AS Sold'),
                DB::raw('DATE_FORMAT(MIN(orders.payment_release_date), "%M %Y") AS Month')
            )
                ->where('shop_id', $shop->id)
                ->where('orderStatus', 'done')
                ->groupBy(DB::raw('YEAR(orders.payment_release_date), MONTH(orders.payment_release_date)'))
                ->get();
            return $order;
        });

        return response()->json($result);
    }

    public function top5Popular(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $shop = Shop::where("user_id", Auth::user()->id)->first();

            $data = Order::select(DB::raw('COUNT(order_details.product_id) AS Sold'), DB::raw('MIN(products.name) AS Name'))
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'products.id', '=', 'order_details.product_id')
                ->where('orders.shop_id', $shop->id)
                ->groupBy('order_details.product_id')
                ->limit(5)
                ->get();

            return $data;
        });
        return response()->json($result);
    }
}
