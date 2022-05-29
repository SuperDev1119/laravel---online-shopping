@component('mail::message')
# Hi {{ $merchant->name }} !
Your Dashboard is ready !
You can login on this url : {{ $link }}
user : {{ $merchant->email }}
pass : **{{ $merchant->password }}**
_Please remember to change your password after your first login._
## Next Steps:
With your access to the Modalova Dashboard now created, we are ready to start the technical integration !
Please follow the instructions from this page : {{ $link_to_doc }}
Best,
{{ config('app.name') }}
@endcomponent
