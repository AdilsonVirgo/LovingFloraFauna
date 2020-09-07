<?php

namespace App\Http\Controllers\Servicios;

use App\Provincia;
use App\Alojamiento;
use App\Instalacion;
use App\Reserva;
use App\Servicio;
use App\ReservaAlojamiento;
use App\ReservaSendero;
use App\Ueb;
use App\User;
use App\Notifications\NotificacionReserva;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;

class ProvinciaController extends Controller {
    /* api */

    public function JSON() {
        Try {
            $provincias = \App\Provincia::all();
            //$provincias = \App\Provincia::all()->toJson();
            $logmessage = 'Good';
            //return \Response::json(['provincias' => $provincias, 'error' => null]);
            //return \Response::json(['data' => $provincias]);
            return \Response::json($provincias->toJson());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['provincias' => null, 'error' => $e->getMessage()]);
        }
    }

    /* public function JSON() {
      Try {
      $provincias = \App\Provincia::all();
      $logmessage = 'Good';
      //return \Response::json(['provincias' => $provincias, 'error' => null]);
      //return \Response::json(['data' => $provincias]);
      return \Response::json([$provincias]);
      } catch (\Exception $e) {
      \Log::info($e->getMessage());
      return \Response::json(['provincias' => null, 'error' => $e->getMessage()]);
      }
      } */

    public function JSONPOST() {
        Try {
            $provincias = \App\Provincia::all()->toJson();
            $logmessage = 'Good';
            //return \Response::json(['provincias' => $provincias, 'error' => null]);
            //return \Response::json(['data' => $provincias]);
            return \Response::json([$provincias]);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return \Response::json(['provincias' => null, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function salvarWORD() {
        /* $provincias = \App\Provincia::all(); //->sortByDesc('id') ;
          $a = \App\Alojamiento::all(); //->sortByDesc('id') ;
          $i = \App\Instalacion::all(); //->sortByDesc('id') ;
          $m = \App\Mercado::all(); //->sortByDesc('id') ;
          $ra= \App\ReservaAlojamiento::all(); //->sortByDesc('id') ;
          $r = \App\Reserva::all(); //->sortByDesc('id') ;

          //$image = $post->image;
          dd($ra->first()->reserva->servicios->first());
          return view('provincias.index', compact('provincias'));
          // return view('provincias.i'); */
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        /* Note: any element you append to a document must reside inside of a Section. */

// Adding an empty Section to the document...
        $section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
        $section->addText(
                '"Learn from yesterday, live for today, hope for tomorrow. '
                . 'The important thing is not to stop questioning." '
                . '(Albert Einstein)'
        );

        /*
         * Note: it's possible to customize font style of the Text element you add in three ways:
         * - inline;
         * - using named font style (new font style object will be implicitly created);
         * - using explicitly created font style object.
         */

// Adding Text element with font customized inline...
        $section->addText(
                '"Great achievement is usually born of great sacrifice, '
                . 'and is never the result of selfishness." '
                . '(Napoleon Hill)', array('name' => 'Tahoma', 'size' => 10)
        );

// Adding Text element with font customized using named font style...
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
                $fontStyleName, array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
        );
        $section->addText(
                '"The greatest accomplishment is not in never falling, '
                . 'but in rising again after you fall." '
                . '(Vince Lombardi)', $fontStyleName
        );

// Adding Text element with font customized using explicitly created font style object...
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(13);
        $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
        $myTextElement->setFontStyle($fontStyle);

// Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('helloWorld.docx');

// Saving the document as ODF file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        $objWriter->save('helloWorld.odt');

// Saving the document as HTML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save('helloWorld.html');
    }

    public function index() {
        $provincias = \App\Provincia::all(); //->sortByDesc('id') ;
        return view('provincias.index', compact('provincias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $provincias = \App\Provincia::all();
        return view('provincias.create', compact('provincias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $attributes = $request->validate([
            'name' => ['required', 'max:200', 'unique:provincias'],
            'activa' => ['boolean'],
            'observaciones' => [],
        ]);
        $retorno = tap(new Provincia($attributes))->save();
        if ($retorno) {
            return redirect()->to(url('/provincias'))->with('status', '-' . __('Provincia insertada'));
        } else {
            return redirect()->to(url('/provincias'))->with('status', '-' . __('Provincia no insertada'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Provincia $provincia) {
        //$provincia = Provincia::find($id);
        //dd($provincia);
        return view('provincias.show', compact($provincia, 'provincia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function edit(Provincia $provincia) {
        return view('provincias.edit', compact($provincia, 'provincia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provincia $provincia) {
        $attributes = $request->validate([
            'name' => ['required', 'max:200'],
            'activa' => ['required', 'boolean'],
            'observaciones' => [],
        ]);
        $retorno = \DB::table('provincias')
                ->where('id', $provincia->id)
                ->update($attributes);
        if ($retorno) {
            return redirect()->to(url('/provincias'))->with('status', '-' . __('Provincia Actualizada'));
        } else {
            return redirect()->to(url('/provincias'))->with('status', '-' . __('Provincia no Actualizada'));
        }
    }

    /**
     * Show the form for banning the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function ban(Provincia $id) {
        \DB::table('provincias')
                ->where('id', $id->id)
                ->update(['activa' => false]);
        return redirect()->to(url('/provincias'))->with('status', '-' . __('Provincia Inactiva'));
        //return view('provincias.ban', compact($provincia, 'provincia'));//no me preguntes porque funciona
    }

}
