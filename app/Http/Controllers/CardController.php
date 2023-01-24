<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

class CardController extends Controller
{
    // define cards
    public  $shapes = array('S', 'H', 'D', 'C');
    public $numbers = array('A', '2', '3', '4', '5', '6', '7', '8', '9', 'X', 'J', 'Q', 'K');
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $shuffled_sets = [];
        $no_people = '';
        return view('card.index', compact('shuffled_sets', 'no_people'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'no_people' => 'required|integer|min:1',
        ], [
            'no_people.requried' => 'Input value does not exist or value is invalid'
        ]);


        // Card Nomenclature
        $cards = array();
        foreach($this->shapes as $shape) {
            foreach($this->numbers as $number) {
                $cards[] = $shape.$number;
            }
        }

        // Shuffle the Cards
        $collection = collect($cards);
        $shuffled = $collection->shuffle();
        $shuffled->all();

        $no_people = $request->no_people;
        $cards_per_person = floor(count($shuffled) / $no_people);
        if ($cards_per_person < 1)
            $cards_per_person = 1;

        // Distribute the Cards to n-peopnel
        $shuffled_sets = [];
        for($i = 0; $i < $no_people; $i++) {
          $temp_shuffleds = [];
            for($j = $i * $cards_per_person; $j < ($i + 1) * $cards_per_person; $j++) {
                if ($j < 52) {
                    array_push($temp_shuffleds,$shuffled[$j]);
                    unset($shuffled[$j]);
                }
            }
            array_push($shuffled_sets, $temp_shuffleds);
        }

        return view('card.index', compact('no_people', 'shuffled_sets'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
