@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">Blog Details</h3>

    <div class="card">

        <div class="card-body">

            <h2>{{ $blog->title }}</h2>

            <p class="text-muted">

                Category:
                <strong>{{ $blog->category->name }}</strong>

                |

                Author:
                <strong>{{ $blog->author->name }}</strong>

                |

                Views:
                <strong>{{ $blog->views }}</strong>

            </p>

            @if($blog->featured_image)

            <img src="{{ asset('storage/'.$blog->featured_image) }}"
                class="img-fluid mb-4">

            @endif

            <div class="blog-content">

                {!! $blog->content !!}

            </div>

        </div>

    </div>

</div>

@endsection