<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Normalizer;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::query()
            ->keyword($request->keyword)
            ->gender($request->gender)
            ->category($request->category_id)
            ->createdDate($request->created_at)
            ->orderBy('created_at', 'desc')
            ->paginate(7)
            ->withQueryString();

        return view('admin.dashboard', compact('contacts'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('dashboard')
            ->with('status', 'お問い合わせを削除しました。');
    }

    public function export(Request $request)
    {
        $contacts = Contact::query()
            ->keyword($request->keyword)
            ->gender($request->gender)
            ->category($request->category_id)
            ->createdDate($request->created_at)
            ->orderBy('created_at', 'desc')
            ->get();

        $csvHeader = [
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'category_id',
            'detail',
            'created_at',
        ];

        $csvData = implode(",", $csvHeader) . "\n";

        foreach ($contacts as $c) {
            $csvData .= implode(",", [
                $c->last_name,
                $c->first_name,
                $c->gender,
                $c->email,
                $c->tel,
                $c->address,
                $c->building,
                $c->category_id,
                $c->detail,
                $c->created_at,
            ]) . "\n";
        }

        $filename = 'contacts_export_' . date('Ymd_His') . '.csv';

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}