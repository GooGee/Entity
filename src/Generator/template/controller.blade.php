
namespace @echo($controller->nameSpace);

use @echo($model->nameSpace)\@echo($model->name);
use Illuminate\Http\Request;

class @echo($controller->name) extends Controller
{

    function __construct()
    {
@foreach($controller->middlewareList as $middleware)
        @echo($middleware->text)

@endforeach
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $@echo($model->instance)List = @echo($model->name)::all();
        return view('@echo($controller->blade).index', compact('@echo($model->instance)List'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $@echo($model->instance) = new @echo($model->name);
        $@echo($model->instance)->_token = csrf_token();
        $@echo($model->instance)->_url = '/@echo($model->instance)';
        return view('@echo($controller->blade).form', compact('@echo($model->instance)'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $array = $this->validate($request, @echo($model->name)::$ruleArray);
        $@echo($model->instance) = new @echo($model->name);
        $@echo($model->instance)->fill($array);
        $@echo($model->instance)->save();
        return redirect('/@echo($controller->blade)/' . $@echo($model->instance)->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $@echo($model->instance) = @echo($model->name)::findOrFail($id);
        return view('@echo($controller->blade).show', compact('@echo($model->instance)'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $@echo($model->instance) = @echo($model->name)::findOrFail($id);
        $@echo($model->instance)->_token = csrf_token();
        $@echo($model->instance)->_method = 'PATCH';
        $@echo($model->instance)->_url = '/@echo($model->instance)/' . $id;
        return view('@echo($controller->blade).form', compact('@echo($model->instance)'));
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
        $array = $this->validate($request, @echo($model->name)::$ruleArray);
        $@echo($model->instance) = @echo($model->name)::findOrFail($id);
        $@echo($model->instance)->update($array);
        return redirect('/@echo($controller->blade)/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $@echo($model->instance) = @echo($model->name)::findOrFail($id);
        $@echo($model->instance)->delete();
        return redirect('/@echo($controller->blade)');
    }
}
