public function addToCart(Request $request)
{
    $validated = $request->validate([
        'menu_id' => 'required|integer|exists:menus,menu_id',
        'restaurant_id' => 'required|integer|exists:restaurants,restaurant_id',
    ]);

    $menuId = $validated['menu_id'];
    $restaurantId = $validated['restaurant_id'];

    // Logika untuk menambahkan item ke keranjang
    // Misalnya, tambahkan ke sesi atau database
    // Contoh:
    $cart = session()->get('cart', []);
    $cart[] = ['menu_id' => $menuId, 'restaurant_id' => $restaurantId];
    session()->put('cart', $cart);

    return response()->json(['success' => true, 'cart' => $cart]);
}

public function checkout(Request $request)
{
    $cart = $request->all();
    // Proses checkout, simpan ke database, dll.
    return response()->json(['success' => true, 'message' => 'Checkout berhasil']);
}