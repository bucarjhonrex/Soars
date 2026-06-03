<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $student_id = $request->student_id;

        // Map file input names to the document_name you want in the table
        $documents = [
            'form137' => 'Form 137 / TOR',
            'birth_certificate' => 'Birth Certificate',
            'good_moral' => 'Good Moral Certificate',
            'medical_form' => 'Medical Form',
            'id_picture' => 'ID Picture (2x2)',
        ];

        foreach ($documents as $field => $name) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store('documents'); // stores in storage/app/documents

                // Save to database
                Document::updateOrCreate(
                    [
                        'student_id' => $student_id,
                        'document_name' => $name
                    ],
                    [
                        'file_path' => $path,
                        'Status' => 'Pending'
                    ]
                );
            }
        }

        return response()->json(['message' => 'Documents uploaded successfully']);
    }
}

