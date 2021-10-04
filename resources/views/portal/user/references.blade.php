@extends('layouts.portal')

@section('title', 'My Team')

@section('content')
    @include('partials.page-title', ['title' => 'My Team'])
    <section class="main-container col2-right-layout">
        <div class="main container">
            <div class="my-account">
                <!--page-title-->
                <!-- BEGIN DASHBOARD-->
                <div class="dashboard">
                    <h2>{{ $user->fullName() }}</h2>
                    <p>Stage: {{ $user->designation->stage }}</p>
                    <p>Designation: {{ $user->designation->name }}</p>
                    <p>Members: {{ $user->childs()->count() }}</p>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Designation</th>
                                <th>Stage</th>
                                <th>Members</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($designations as $designation)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    @if($loop->index < 3)
                                        <a href="?designation={{ $designation->id }}">{{ $designation->name }}</a>
                                    @else
                                        {{ $designation->name }}
                                    @endif
                                </td>
                                <td>{{ $designation->stage }}</td>
                                <td>{{ $designation->users_count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    @if(request()->filled('designation'))
                    <h2>References Users</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Designation</th>
                                <th>RM</th>
                                <th>UM</th>
                                <th>Total</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($reference_users as $reference_user)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td><a href="/portal/reference-users/{{ $reference_user->id }}">{{ $reference_user->fullName() }}</a></td>
                                <td>{{ $reference_user->registered_count }}</td>
                                <td>{{ $reference_user->unregistered_count }}</td>
                                <td>{{ $reference_user->unregistered_count + $reference_user->registered_count }}</td>
                                <td><a href="{!! route('portal.sms.send', $reference_user) !!}">Send SMS</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
        <!--main container-->
    </section>
@endsection