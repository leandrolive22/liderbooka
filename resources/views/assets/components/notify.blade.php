{{-- laravel alerts in JS $.noty({...}) --}}
@if($errors->any()) 
    @foreach($errors->all() as $error)
    noty({
        text: "{{ json_encode($error) }}", 
        layout: 'topRight', 
        type: 'error', 
        timeout: '5000'
        })
    @endforeach
@elseif(session('successAlert'))
    noty({
        text: "{{ session('successAlert') }}", 
        layout: 'topRight', 
        type: 'success', 
        timeout: '5000'
    })
@elseif(session('errorAlert'))
    noty({
        text: "{{ session('errorAlert') }}", 
        layout: 'topRight', 
        type: 'error', 
        timeout: '5000'
    })
@endif