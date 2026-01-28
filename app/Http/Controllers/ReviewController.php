<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Gemini;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public $AIGenerated;

    public function get_reviews()
    {
        $reviews = Review::orderBy("created_at", "desc")->paginate(10);
        return view("reviews", compact("reviews"));
    }

    public function analyze()
    {
        $apiKey = getenv("GEMINI_API_KEY");
        $client = Gemini::client($apiKey);
        $selectedReview = request()->input('review');
        $prompt = "Op mijn website staan reviews over mijn restaurant helaas zijn sommige hiervan aanstootgevend maar zou jij mij een lijst met mogelijke verbeterpunten kunnen geven voor mijn restaurant aangeleid door de volgende reviews gebruik geen titels geef mij alleen specifieke verbeterpunten zonder uitleg: $selectedReview";
        $result = $client
            ->geminiPro()
            ->generateContent($prompt);
        $responseText = $result->text();
        $lines = explode("\n", $responseText);
        // Process each line to wrap with <li> tags if it starts with *
        $formattedItems = "";
        foreach ($lines as $line) {
            // Check if the line starts with '* ' and format it as <li>
            if (preg_match('/^\*\s?(.*)/', $line, $matches)) {
                $formattedItems .= "<li>" . trim($matches[1]) . "</li>";
            }
        }
        // return the formatted content
        return response()->json([
            'data' => $formattedItems,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'review_details' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        Review::create($request->all());
        return redirect()->back()->with('success', 'Review is succesvol toegevoegd!');
    }
    public function update($id, Request $request)
    {
        try
        {
            $updateReview = Review::findOrFail($id);
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'review_details' => 'required|string|max:255',
                'rating' => 'integer|min:1|max:5',
            ]);
            
            $updateReview->update([
                'name' => $request->name,
            'email' => $request->email,
            'review_details' => $request->review_details,
            ]);
            if($request->has('rating')){
                $updateReview->update([
                    'rating' => $request->rating
                ]);
            }
        
            return redirect()->back()->with('success', 'Review is succesvol geupdate!');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'Er is iets fout gegaan! Probeer het opnieuw.');
        }
    }

    public function destroy($id)
    {
        $deleteReview = Review::findOrFail($id);
        $deleteReview->delete();
        return redirect()->back()->with('success', 'Review is succesvol verwijderd!');
    }
}
