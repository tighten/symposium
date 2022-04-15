<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - Authorization</title>

    <!-- Styles -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <style>
        .passport-authorize .container {
            margin-top: 250px;
        }

        .passport-authorize .scopes {
            margin-top: 20px;
        }

        .passport-authorize .buttons {
            margin-top: 25px;
            text-align: center;
        }

        .passport-authorize .btn {
            width: 125px;
        }

        .passport-authorize .btn-approve {
            margin-right: 15px;
        }

        .passport-authorize form {
            display: inline;
        }
    </style>
</head>
<body class="passport-authorize">
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-center">
            <div class="md:w-1/2 pr-4 pl-4">
                <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-grey-light">
                    <div class="py-3 px-6 mb-0 bg-blue-dark border-b-1 border-grey-light text-grey-lightest text-center">
                        Authorization Request
                    </div>
                    <div class="flex-auto p-6">
                        <!-- Introduction -->
                        <p><strong>{{ $client->name }}</strong> is requesting permission to access your account.</p>

                        <!-- Scope List -->
                        @if (count($scopes) > 0)
                            <div class="scopes">
                                    <p class="pb-2"><strong>This application will be able to:</strong></p>

                                    <ul>
                                        @foreach ($scopes as $scope)
                                            <li class="pb-1">{{ $scope->description }}</li>
                                        @endforeach
                                    </ul>
                            </div>
                        @endif

                        <div class="text-center pt-5">
                            <!-- Authorize Button -->
                            <form method="post" action="{{ url('/oauth/authorize') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button type="submit" class="inline-block align-middle text-center select-none border font-normal whitespace-nowrap py-2 px-4 rounded text-base leading-normal no-underline text-teal-lightest bg-teal-dark hover:bg-grey-darker btn-approve">Authorize</button>
                            </form>

                            <!-- Cancel Button -->
                            <form method="post" action="{{ url('/oauth/authorize') }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button class="inline-block align-middle text-center select-none border font-normal whitespace-nowrap py-2 px-4 rounded text-base leading-normal no-underline text-white bg-red-dark hover:bg-grey-darker">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
