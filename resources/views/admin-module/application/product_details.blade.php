@extends('Layouts\main')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <body>
        <div class="container">
            <section class="content">
                <section class="work-area">

                    <div class="pages">

                        @livewire('product-detials', ['MainServiceId' => $MainServiceId])
                    </div>
                </section>
            </section>
        </div>
    </body>

    </html>
@endsection
