@component('mail::message')

Dear {{$user->name}},

We are thrilled to welcome you to {{config('app.name')}}! On behalf of our entire team, I would like to express our sincere appreciation for joining our online community.

At {{config('app.name')}}, our mission is to connects you with other people in the world.

Best regards,

Yanal Shoubaki
CEO
{{config('app.name')}}

@endcomponent
