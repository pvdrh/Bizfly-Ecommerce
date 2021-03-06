<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Http\Requests\ImportOrderRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Imports\CustomersImport;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Illuminate\Support\Facades\Log;
use Exception;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_role = Auth::user()->info->role;
        if ($user_role == UserInfo::ROLE['admin']) {
            $orders = Order::paginate(10);
        } else {
            $user_code = Auth::user()->info->code;
            $customers = Customer::where(['employee_code' => $user_code])->get();
            $customer_id = [];
            foreach ($customers as $customer) {
                $customer_id[] = $customer->_id;
            }
            $orders = Order::whereIn('customer_id', $customer_id);
            $orders = $orders->paginate(10);
        }
        return view('orders.index')->with([
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        $user_code = Auth::user()->info->code;
        if (Auth::user()->info->role == UserInfo::ROLE['admin']) {
            $customers = Customer::get();
        } else {
            $customers = Customer::where(['employee_code' => $user_code])->get();
        }
        return view('orders.create')->with([
            'products' => $products,
            'customers' => $customers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            $order = new Order();

            $order->code = 'DH' . rand(1000, 9999);
            $order->status = Order::STATUS['pending'];
            $order->note = $request->note;
            $order->customer_id = $request->customer_id;
            $order->product_id = $request->product_id;
            $product_ids = $request->product_id;
            $products = Product::whereIn('_id', $product_ids)->get();
            $total = 0;
            foreach ($products as $product) {
                $total += $product->price;
                $product->total_sold += 1;
                $product->quantity -= 1;
                $product->save();
            }
            $order->total = $total;
            $order->save();

            Session::flash('success', 'T???o m???i th??nh c??ng!');
        } catch (Exception $e) {
            Log::error('Error store order', [
                'method' => __METHOD__,
                'message' => $e->getMessage(),
                'line' => __LINE__
            ]);

            Session::flash('error', 'T???o m???i th???t b???i!');
        }

        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('orders.edit')->with([
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function acceptOrder($id)
    {
        try {
            $order = Order::find($id);
            $order->status = Order::STATUS['approved'];
            $order->save();

            Session::flash('success', 'Duy???t ????n th??nh c??ng!');
        } catch (Exception $e) {
            Log::error('Error accept order', [
                'method' => __METHOD__,
                'message' => $e->getMessage(),
                'line' => __LINE__
            ]);

            Session::flash('error', 'Duy???t ????n th???t b???i!');
        }
        return redirect()->route('orders.index');
    }

    public function cancelOrder($id)
    {
        try {
            $order = Order::find($id);
            $order->status = Order::STATUS['canceled'];
            $product_ids = $order->product_id;
            $products = Product::whereIn('_id', $product_ids)->get();
            foreach ($products as $product) {
                $product->total_sold -= 1;
                $product->quantity += 1;
                $product->save();
            }
            $order->save();

            Session::flash('success', 'H???y ????n th??nh c??ng!');
        } catch (Exception $e) {
            Log::error('Error cancel order', [
                'method' => __METHOD__,
                'message' => $e->getMessage(),
                'line' => __LINE__
            ]);

            Session::flash('error', 'H???y th???t b???i!');
        }
        return redirect()->route('orders.index');
    }

    public function returnOrder($id)
    {
        try {
            $order = Order::find($id);
            $order->status = Order::STATUS['return'];
            $product_ids = $order->product_id;
            $products = Product::whereIn('_id', $product_ids)->get();
            foreach ($products as $product) {
                $product->total_sold -= 1;
                $product->quantity += 1;
                $product->save();
            }
            $order->save();

            Session::flash('success', 'Ho??n ????n th??nh c??ng!');
        } catch (Exception $e) {
            Log::error('Error return order', [
                'method' => __METHOD__,
                'message' => $e->getMessage(),
                'line' => __LINE__
            ]);

            Session::flash('error', 'Duy???t ????n th???t b???i!');
        }
        return redirect()->route('orders.index');
    }

    public function exportExcel(Request $request)
    {
        if ($request->ids) {
            $ids = $request->ids;
            $idsArr = explode(",", $ids);
        }
        if (!empty($idsArr)) {
            $orders = Order::whereIn('_id', $idsArr)->get();
        } else if (Auth::user()->info->role == UserInfo::ROLE['admin']) {
            $orders = Order::get();
        } else {
            $user_code = Auth::user()->info->code;
            $orders = Order::where(['employee_code' => $user_code])->get();
        }
        return Excel::download(new OrdersExport($orders), 'Danh s??ch ????n h??ng.xlsx');
    }

    public function getListOrder(Request $request, $id)
    {
        $orders = Order::where('customer_id', $id)->get();

        return view('orders.index')->with([
            'orders' => $orders
        ]);
    }

    public function importExcel(ImportOrderRequest $request)
    {
        try {
            $orders = Excel::toArray(new CustomersImport(), $request->file('file'));
            $orders = $orders[0];
            if (count($orders)) {
                foreach ($orders as $key => $order) {
                    $oldOrder = Order::where('code', $order[0])->count();
//                    if ($oldOrder == 0) {
                    if (strlen($order[2]) > 0) {
                        $customer = Customer::find($order[2]);
                        if ($customer) {
                            $newOrder = new Order();
//                                if (strlen($order[0]) < 6) {
                            $newOrder->code = 'DH' . rand(1000, 9999);
//                                } else {
//                                    $newOrder->code = $order[0];
//                                }
                            if (empty($order[0])) {
                                $newOrder->status = Order::STATUS['0'];
                            } else {
                                $newOrder->status = $order[0];
                            }
                            $newOrder->note = $order[1] ? $order[1] : '';
                            $newOrder->customer_id = $order[2];
                            $newOrder->total = $order[3];
                            $newOrder->save();

                            Session::flash('success', 'Th??m m???i th??nh c??ng!');
                        } else {
                            Session::flash('error', 'M?? kh??ch h??ng kh??ng t???n t???i!');
                        }
                    } else {
                        Session::flash('error', 'M?? kh??ch h??ng kh??ng ???????c ????? tr???ng!');
                    }
//                    } else {
//                        Session::flash('error', 'M?? ????n h??ng ???? t???n t???i!');
//                    }
                }
            }
        } catch (Exception $e) {
            Log::error('Error import order from file excel', [
                'method' => __METHOD__,
                'message' => $e->getMessage(),
                'line' => __LINE__
            ]);

            Session::flash('error', 'File excel kh??ng ????ng ?????nh d???ng!');
        }

        return redirect()->route('orders.index');
    }

    public function exportExcelSample()
    {
        $file = public_path() . '/template/import_order_template.xlsx';
        return response()->download($file, 'import_order_template.xlsx');
    }

    public function deleteAll(Request $request)
    {
        try {
            if ($request->ids) {
                $ids = $request->ids;
                $idsArr = explode(",", $ids);
            }
            if (!empty($idsArr)) {
                Order::whereIn('_id', $idsArr)->delete();
            } else if (Auth::user()->info->role == UserInfo::ROLE['admin']) {
                Order::query()->delete();
            } else {
                $user_code = Auth::user()->info->code;
                Order::where(['employee_code' => $user_code])->delete();
            }

            Session::flash('success', 'X??a th??nh c??ng!');
        } catch (Exception $e) {
            Log::error('Error delete all category', [
                'method' => __METHOD__,
                'message' => $e->getMessage(),
                'line' => __LINE__
            ]);

            Session::flash('error', 'X??a th???t b???i!');
        }
        return redirect()->route('categories.index');
    }
}
