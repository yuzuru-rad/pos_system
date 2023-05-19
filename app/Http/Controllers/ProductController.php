<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\Earning;
use App\Models\VaultEarning;
use App\Models\VaultShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * 急になぜか作ることになった登録画面
     * あって損するものじゃないので、productsのDBに商品を登録する
     */

    public function register(Request $request)
    {
        // バリデーションを行う
        $validatedData = $request->validate([
            'product_name' => 'required|string',
            'product_code' => 'required|numeric',
            'price' => 'required|numeric',
            'taxrate' => 'required|in:0.08,0.10', // 0.08または0.10のいずれかの値であることを検証
            'taxinclude_price' => 'required|numeric',
        ]);

        $hasAlready = Product::where('product_code',$validatedData['product_code'])->first();
        if($hasAlready){
            Log::debug("hoge");
            return view('update',[
                'product_name' => $validatedData['product_name'],
                'product_code' => $validatedData['product_code'],
                'price' => $validatedData['price'],
                'taxrate' => $validatedData['taxrate'],
                'taxinclude_price' => $validatedData['taxinclude_price'],
            ]);
        }
        //商品を登録
        $product = new Product();
        $product->product_name = $validatedData['product_name'];
        $product->product_code = $validatedData['product_code'];
        $product->price = $validatedData['price'];
        $product->taxrate = $validatedData['taxrate'];
        $product->taxinclude_price = $validatedData['taxinclude_price'];
        $product->save();

        //登録画面に戻し、完了メッセージを出す
        return redirect('/register')->with('flash_message', '登録完了しました。');
    }

    public function registerUpdate(Request $request)
    {
                // バリデーションを行う
        $validatedData = $request->validate([
            'product_name' => 'required|string',
            'product_code' => 'required|numeric',
            'price' => 'required|numeric',
            'taxrate' => 'required|in:0.08,0.10', // 0.08または0.10のいずれかの値であることを検証
            'taxinclude_price' => 'required|numeric',
        ]);

        $targetProduct = Product::where('product_code',$validatedData['product_code'])->first();
        if($targetProduct){
            $targetProduct->product_name = $validatedData['product_name'];
            $targetProduct->product_code = $validatedData['product_code'];
            $targetProduct->price = $validatedData['price'];
            $targetProduct->taxrate = $validatedData['taxrate'];
            $targetProduct->taxinclude_price = $validatedData['taxinclude_price'];
            $targetProduct->save();
        }
        return redirect('/register')->with('flash_message', '更新完了しました。');

    }

    public function registerCansel(Request $request){
        return redirect('/register')->with('flash_message', '更新キャンセルしました。');
    }

    /**
     * 検索機能
     * バーコードを読み取って、DBを見に行く
     * 読み取った商品を買い物かごに追加
     */
    public function search(Request $request)
    {   
        $barcode = $request->input('barcode');
        //$barcode = 4946842529209;
        log::debug([$barcode]);
        // バーコード値を使って商品を検索
        $product = Product::where('product_code', $barcode)->first();

        // $product の情報を shoppingcarts テーブルに移す
        if ($product) {
            $shoppingCart = new ShoppingCart();
            $shoppingCart->product_name = $product->product_name;
            $shoppingCart->price = $product->price;
            $shoppingCart->taxrate = $product->taxrate;
            $shoppingCart->taxinclude_price = $product->taxinclude_price;
            $isAlready =  ShoppingCart::where('product_name', $shoppingCart->product_name)->first();
            if($isAlready){
                $shoppingCart->amount = $isAlready->amount + 1;
                ShoppingCart::where('product_name', $shoppingCart->product_name)->delete();
            }
            else{
                $shoppingCart->amount = 1;
            }
            $shoppingCart->taxinclude_price_amount = $shoppingCart->taxinclude_price * $shoppingCart->amount;
            $shoppingCart->price_amount = $shoppingCart->price * $shoppingCart->amount;
            $shoppingCart->save();
        }
            $shoppingCart = ShoppingCart::all();
            $totalprice = $shoppingCart->sum('taxinclude_price_amount');
        log::debug([$product]);
        return view('result', [
            'products' => $product,
            'shoppingcart' => $shoppingCart,
            'totalprice' => $totalprice
        ]);
    }

    /**
     * 会計機能
     * 買い物かごの中身の合計金額を計算
     * 税込みだとか税別だとか、まあ色々ありそう
     * 今後調整予定
     * 結局使わないってマジ？？
     * せっかくだから残しとくけど畳みます。
     */
    public function payment(){
        $shoppingCarts = ShoppingCart::all();
        //合計金額（税込み）を計算
        $totalprice = $shoppingCarts->sum('taxinclude_price_amount');

        if($totalprice){
            foreach ($shoppingCarts as $shoppingCart) {
                $earning = new Earning();
        
                // 必要なカラムの値を設定
                $earning->product_name = $shoppingCart->product_name;
                $earning->taxinclude_price = $shoppingCart->taxinclude_price;
                $isAlready =  Earning::where('product_name', $earning->product_name)->first();
                if($isAlready){
                    $earning->amount = $isAlready->amount + $shoppingCart->amount;
                    $earning->taxinclude_price_amount = $isAlready->taxinclude_price_amount + $shoppingCart->taxinclude_price_amount;
                    Earning::where('product_name', $earning->product_name)->delete();
                }
                else{
                    $earning->amount = $shoppingCart->amount;
                    $earning->taxinclude_price_amount = $shoppingCart->taxinclude_price_amount;    
                }

                // earningsテーブルに保存
                $earning->save();
            }        

            //内税8%対象額
            $tax8total = ShoppingCart::where('taxrate', 0.08)->sum('taxinclude_price_amount');

            //内税10%対象額
            $tax10total = ShoppingCart::where('taxrate', 0.1)->sum('taxinclude_price_amount');

            //内消費税などを計算
            $onlytax = $totalprice - $shoppingCarts->sum('price');
;           
            //check.blade.phpへ渡す
            //渡すデータが多いので配列形式で。
            return view('check',[
                'shoppingcart' => $shoppingCarts,
                'totalprice' => $totalprice,
                'tax8rate' => $tax8total,
                'tax10rate' => $tax10total,
                'onlytax' => $onlytax
                ]);

        }
        
        
    }

        /**
     * 決済処理の一環で、レシートに必要なデータを計算する。
     * そして必要な内容をpayment.blade.phpに渡す
     */
    public function processPayment(Request $request)
    {   
        $bill = $request->input('bill');

        $shoppingCarts = ShoppingCart::all();
        //合計金額（税込み）を計算
        $totalprice = $shoppingCarts->sum('taxinclude_price_amount');

            //内税8%対象額
            $tax8total = ShoppingCart::where('taxrate', 0.08)->sum('taxinclude_price_amount');

            //内税10%対象額
            $tax10total = ShoppingCart::where('taxrate', 0.1)->sum('taxinclude_price_amount');

            //内消費税などを計算
            $onlytax = $totalprice - $shoppingCarts->sum('price_amount');

            //お釣りを計算
            $change = $bill - $totalprice;


            //やや複雑な処理
            //web.phpにある、
            //Route::get('/receipt', [ProductController::class, 'showReceipt'])->name('receipt');
            //を読んできて、下記のfunctionを走らせる。
            //GETとPOSTでうまくいかないため、回避策
            return redirect()->route('receipt')->with([
                'shoppingcart' => $shoppingCarts,
                'totalprice' => $totalprice,
                'tax8rate' => $tax8total,
                'tax10rate' => $tax10total,
                'onlytax' => $onlytax,
                'bill' => $bill,
                'change' => $change
            ]);
        }

    /**
     * 上記回避策の本体
     */
    public function showReceipt()
    {
        return view('receipt');
    }

    /**
     * さらにここの処理が増える
     * このタイミングでearningsにsaveすることにする。
     * 待機画面を呼び寄せ、その際にshopping_cartsの中身を空にする
     * 空にする直前に、その中身を全て、vault_shopping_cartsに中身を移す。
     */
    public function showWaitScreen()
    {
        $shoppingCarts = ShoppingCart::all();
            
        foreach ($shoppingCarts as $shoppingCart) {
            $earning = new Earning();
        
            // 必要なカラムの値を設定
            $earning->product_name = $shoppingCart->product_name;
            $earning->taxinclude_price = $shoppingCart->taxinclude_price;
            $isAlready =  Earning::where('product_name', $earning->product_name)->first();
            if($isAlready){
                $earning->amount = $isAlready->amount + $shoppingCart->amount;
                $earning->taxinclude_price_amount = $isAlready->taxinclude_price_amount + $shoppingCart->taxinclude_price_amount;
                Earning::where('product_name', $earning->product_name)->delete();
            }
            else{
                $earning->amount = $shoppingCart->amount;
                $earning->taxinclude_price_amount = $shoppingCart->taxinclude_price_amount;    
            }

            // earningsテーブルに保存
            $earning->save();

            $vault = new VaultShoppingCart();

            // 必要なカラムの値を設定
            $vault->product_name = $shoppingCart->product_name;
            $vault->price = $shoppingCart->price;
            $vault->taxrate = $shoppingCart->taxrate;
            $vault->amount = $shoppingCart->amount;
            $vault->taxinclude_price = $shoppingCart->taxinclude_price;
            $vault->taxinclude_price_amount = $shoppingCart->taxinclude_price_amount;
            $vault->price_amount = $shoppingCart->price_amount;

            // vault_shopping_cartsテーブルに保存
            $vault->save();
    
        } 

        // ShoppingCart テーブルをクリアする
        ShoppingCart::truncate();
        // 待機画面のビューを表示する
        return view('basic');
    }

    /**
     * 売上照会
     */
    public function showEarnings(){
        $earnings = Earning::all();
        $totalprice = $earnings->sum('taxinclude_price_amount');
        return view('earning',[
            'earning' => $earnings,
        'totalprice' => $totalprice
    ]);
    }


    /**
     * こっちは売り上げを上のshopping_cartのごとく保存して空にする手順
     */
    public function confirmEarnings()
    {
        $earnings = Earning::all();

        foreach ($earnings as $earning) {
            $vault = new VaultEarning();
    
            // 必要なカラムの値を設定
            $vault->product_name = $earning->product_name;
            $vault->amount = $earning->amount;
            $vault->taxinclude_price = $earning->taxinclude_price;
            $vault->taxinclude_price_amount = $earning->taxinclude_price_amount;
            // vault_earning_cartsテーブルに保存
            $vault->save();
        }

        // ShoppingCart テーブルをクリアする
        Earning::truncate();

        // 待機画面のビューを表示する
        return view('basic');
    }


    /**
     * ココからの一連は全てカートの中身をいじる機能
     * カートの中身を閲覧し、内容の訂正を行う
     * 用検討はコントローラーの分離。
     */

    public function showCart()
    {
        $shoppingcart = ShoppingCart::all();
        return view('showcart', compact('shoppingcart'));
    }

    public function correctionCart($id)
    {
        $cartItem = ShoppingCart::findOrFail($id);
        return view('correctioncart', compact('cartItem'));
    }

    public function updateCart(Request $request, $id)
    {
        $cartItem = ShoppingCart::findOrFail($id);
        $cartItem->amount = $request->get('amount');
        //ここでamountに基づく全体価格計算を行う
        $cartItem->taxinclude_price_amount = $cartItem->taxinclude_price * $cartItem->amount;
        $cartItem->price_amount = $cartItem->price * $cartItem->amount;
        $cartItem->save();
        return redirect()->route('showcart');
    }

    public function deleteCart($id)
    {
        $cartItem = ShoppingCart::findOrFail($id);
        $cartItem->delete();
        return redirect()->route('showcart');
    }

    public function returnResult(){
        $shoppingCart = ShoppingCart::all();
        $totalprice = $shoppingCart->sum('taxinclude_price_amount');
        return view('result2')->with([
            'products'  => 13,
            'shoppingcart' => $shoppingCart,
            'totalprice' => $totalprice
        ]);
    }

}
