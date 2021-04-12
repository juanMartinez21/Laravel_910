@extends('principal')
@section('contenido')
    <template v-if="menu==0">
        Bienvenido
    </template>
    <template v-if="menu==1">
        <categoria>
        </categoria>
    </template>
@endsection
