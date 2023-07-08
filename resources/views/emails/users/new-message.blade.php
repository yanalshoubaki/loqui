@component('mail::message')

{{$sender->name}} sent you a message.

{{$message->message}}

@endcomponent
