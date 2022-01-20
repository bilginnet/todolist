<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="text-center my-5">
                    <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
                </div>
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="fs-4 card-title fw-bold mb-4">Register</h1>
                        <form wire:submit.prevent="save" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="name">Name</label>
                                <input wire:model="user.name" id="name" type="text" class="form-control @error('user.name') is-invalid @enderror" autofocus>
                                @error('user.name') <div class="d-block invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="email">E-Mail Address</label>
                                <input wire:model="user.email" id="email" type="email" class="form-control @error('user.email') is-invalid @enderror">
                                @error('user.email') <div class="d-block invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="password">Password</label>
                                <input wire:model="password" id="password" type="password" class="form-control">
                                @error('password') <div class="d-block invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="password_confirmation">Confirm Password</label>
                                <input wire:model="password_confirmation" id="password_confirmation" type="password" class="form-control">
                                @error('password_confirmation') <div class="d-block invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <p class="form-text text-muted mb-3">
                                By registering you agree with our terms and condition.
                            </p>

                            <div class="align-items-center d-flex">
                                <button type="submit" class="btn btn-primary ms-auto">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer py-3 border-0">
                        <div class="text-center">
                            Already have an account? <a href="{{ route('login') }}" class="text-dark">Login</a>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5 text-muted">
                    Copyright &copy; 2017-2021 &mdash; Your Company
                </div>
            </div>
        </div>
    </div>
</section>
