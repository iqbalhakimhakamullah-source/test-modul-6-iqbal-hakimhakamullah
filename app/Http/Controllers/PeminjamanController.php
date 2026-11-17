namespace App\Http\Controllers;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function show($id)
    {
        // CELAH A4: Tidak ada pengecekan pemilik
        $peminjaman = Peminjaman::findOrFail($id);
        return response()->json($peminjaman); // Atau return view('peminjaman.show', compact('peminjaman'));
    }
}