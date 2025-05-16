<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Container;
use App\Models\Finishing;
use App\Models\grade;
use App\Models\item;
use App\Models\jenisanyam;
use App\Models\jeniskayu;
use App\Models\origin;
use App\Models\purchase;
use App\Models\warnaanyam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BarcodeController extends Controller
{
    public function index()
    {
        // Fetch all models and pass to the view
        return view('Barcode', [
            'items' => item::all(),
            'buyers' => Buyer::all(),
            'purchases' => purchase::all(),
            'containers' => Container::all(),
            'finishings' => Finishing::all(),
            'grades' => grade::all(),
            'jenisanyams' => jenisanyam::all(),
            'jeniskayus' => jeniskayu::all(),
            'origins' => origin::all(),
            'warnaanyams' => warnaanyam::all(),
        ]);
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'name_item' => 'required|string|max:255',
            'jeniskayu_id' => 'required|exists:jeniskayus,id',
            'grade_id' => 'required|exists:grades,id',
            'finishing_id' => 'required|exists:finishings,id',
            'jenisanyam_id' => 'required|exists:jenisanyams,id',
            'warnaanyam_id' => 'required|exists:warnaanyams,id',
        ]);

        item::create([
            'name_item' => $request->name_item,
            'jeniskayu_id' => $request->jeniskayu_id,
            'grade_id' => $request->grade_id,
            'finishing_id' => $request->finishing_id,
            'jenisanyam_id' => $request->jenisanyam_id,
            'warnaanyam_id' => $request->warnaanyam_id,
        ]);

        return response()->json([
            'name_item' => $request->name_item,
            'jeniskayu_id' => $request->jeniskayu_id,
            'grade_id' => $request->grade_id,
            'finishing_id' => $request->finishing_id,
            'jenisanyam_id' => $request->jenisanyam_id,
            'warnaanyam_id' => $request->warnaanyam_id,
            'success' => true,
            'message' => 'Item created successfully.',
        ]);
    }

    //jenisKayu
    public function storeJenisKayu(Request $request)
    {
        $request->validate([
            'name_jeniskayu' => 'required|string|max:255',
        ]);

        $jeniskayu = jeniskayu::create([
            'name_jeniskayu' => $request->name_jeniskayu,
        ]);

        return response()->json([
            'id' => $jeniskayu->id,
            'name_jeniskayu' => $jeniskayu->name_jeniskayu,
        ]);
    }

    public function destroyJenisKayu(jeniskayu $jeniskayu)
    {
        // Check if the jeniskayu is used in any items
        if ($jeniskayu->items()->exists()) {
            return redirect()->back()->with('error', 'Jenis Kayu cannot be deleted because it is associated with items.');
        }

        // Delete the jeniskayu
        $jeniskayu->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jenis Kayu deleted successfully.',
        ]);
    }

    //grades
    public function storeGrade(Request $request)
    {
        Log::info('Grade form submitted', $request->all());

        $request->validate([
            'name_grade' => 'required|string|max:255',
        ]);

        $grade = grade::create([
            'name_grade' => $request->name_grade,
        ]);

        return response()->json([
            'id' => $grade->id,
            'name_grade' => $grade->name_grade,
        ]);
    }

    public function destroyGrade(grade $grade)
    {
        // Check if the grade is used in any items
        if ($grade->items()->exists()) {
            return redirect()->back()->with('error', 'Grade cannot be deleted because it is associated with items.');
        }

        // Delete the grade
        $grade->delete();

        return response()->json([
            'success' => true,
            'message' => 'Grade deleted successfully.',
        ]);

    }

    //finishings
    public function storeFinishing(Request $request)
    {
        $request->validate([
            'name_finishing' => 'required|string|max:255',
        ]);

        $finishing = Finishing::create([
            'name_finishing' => $request->name_finishing,
        ]);

        return response()->json([
            'id' => $finishing->id,
            'name_finishing' => $finishing->name_finishing,
        ]);
    }

    public function destroyFinishing(Finishing $finishing)
    {
        // Check if the finishing is used in any items
        if ($finishing->items()->exists()) {
            return redirect()->back()->with('error', 'Finishing cannot be deleted because it is associated with items.');
        }

        // Delete the finishing
        $finishing->delete();

        return response()->json([
            'success' => true,
            'message' => 'Finishing deleted successfully.',
        ]);
    }

    //jenisanyam
    public function storeJenisAnyam(Request $request)
    {
        $request->validate([
            'name_jenisanyam' => 'required|string|max:255',
        ]);

        $jenisanyam = jenisanyam::create([
            'name_jenisanyam' => $request->name_jenisanyam,
        ]);

        return response()->json([
            'id' => $jenisanyam->id,
            'name_jenisanyam' => $jenisanyam->name_jenisanyam,
        ]);
    }

    public function destroyJenisAnyam(jenisanyam $jenisanyam)
    {
        // Check if the jenisanyam is used in any items
        if ($jenisanyam->items()->exists()) {
            return redirect()->back()->with('error', 'Jenis Anyam cannot be deleted because it is associated with items.');
        }

        // Delete the jenisanyam
        $jenisanyam->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jenis Anyam deleted successfully.',
        ]);
    }

    //warnaanyam
    public function storeWarnaAnyam(Request $request)
    {
        $request->validate([
            'id_jenisanyam' => 'required|exists:jenisanyams,id',
            'name_warnaanyam' => 'required|string|max:255',
        ]);

        $warnaanyam = warnaanyam::create([
            'jenisanyam_id' => $request->id_jenisanyam,
            'name_warnaanyam' => $request->name_warnaanyam,
        ]);

        return response()->json([
            'id' => $warnaanyam->id,
            'jenisanyam_id' => $warnaanyam->jenisanyam_id,
            'name_warnaanyam' => $warnaanyam->name_warnaanyam,
        ]);
    }

    public function destroyWarnaAnyam(warnaanyam $warnaanyam)
    {
        // Check if the warnaanyam is used in any items
        if ($warnaanyam->items()->exists()) {
            return redirect()->back()->with('error', 'Warna Anyam cannot be deleted because it is associated with items.');
        }

        // Delete the warnaanyam
        $warnaanyam->delete();

        return response()->json([
            'success' => true,
            'message' => 'Warna Anyam deleted successfully.',
        ]);
    }

    // =========================
    // CRUD BUYER
    // =========================
    public function storeBuyer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Buyer::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Buyer added successfully.');
    }

    public function updateBuyer(Request $request, Buyer $buyer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $buyer->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Buyer updated successfully.');
    }

    public function destroyBuyer(Buyer $buyer)
    {
        $buyer->delete();

        return redirect()->back()->with('success', 'Buyer deleted successfully.');
    }

    // =========================
    // CRUD PURCHASE
    // =========================
    public function storePurchase(Request $request)
    {
        $request->validate([
            'buyer_id' => 'required|exists:buyers,id',
            'purchaseindex' => 'required|string|max:255',
        ]);

        Purchase::create([
            'buyer_id' => $request->buyer_id,
            'purchaseindex' => $request->purchaseindex,
        ]);

        return redirect()->back()->with('success', 'Purchase added successfully.');
    }

    public function updatePurchase(Request $request, Purchase $purchase)
    {
        $request->validate([
            'buyer_id' => 'required|exists:buyers,id',
            'purchaseindex' => 'required|string|max:255',
        ]);

        $purchase->update([
            'buyer_id' => $request->buyer_id,
            'purchaseindex' => $request->purchaseindex,
        ]);

        return redirect()->back()->with('success', 'Purchase updated successfully.');
    }

    public function destroyPurchase(Purchase $purchase)
    {
        $purchase->delete();

        return redirect()->back()->with('success', 'Purchase deleted successfully.');
    }

    // =========================
    // API ENDPOINT for Purchase by Buyer (used in dropdown)
    // =========================
    public function getPurchasesByBuyer(Buyer $buyer)
    {
        return $buyer->purchases()->select('id', 'purchaseindex')->get();
    }


}
