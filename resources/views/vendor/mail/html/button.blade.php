@props([
    'url',
    'color' => 'primary',
])

<table align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<a href="{{ $url }}"
style="
display: inline-block;
padding: 12px 24px;
background-color: #ec4899;
border-radius: 6px;
color: #ffffff;
font-weight: 600;
text-decoration: none;
font-size: 14px;
">
{{ $slot }}
</a>
</td>
</tr>
</table>
</td>
</tr>
</table>