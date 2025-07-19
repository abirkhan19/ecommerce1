@props(['url'=>env('APP_URL')])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ url('front/images/requisites/'.$gs->logo) }}" alt="Logo" style="box-sizing:border-box; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif; max-width:100%; border:none; height:75px; max-height:75px; width:75px;">

@else
{{ $slot }}
@endif
</a>
</td>
</tr>
