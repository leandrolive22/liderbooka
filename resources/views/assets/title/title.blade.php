@if(isset($title))
    <title>{{ str_replace('_', ' ',env("APP_NAME","Lider_Book")) }} - {{$title}}</title>
    @else
    <title>{{ str_replace('_', ' ',env("APP_NAME","Lider_Book")) }} - Login</title>
@endif
