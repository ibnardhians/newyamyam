@extends('layouts.auth')

@section('content')

<div class="page-content page-auth" id="register">
    <div class="section-store-auth" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center justify-content-center row-login">
                <h3 class="text-center">
                    Memulai untuk beli snack <br />
                    dengan cara terbaru
                </h3>
                <div class="col-lg-5">
                    <form class="mt-3" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input 
                                v-model="name"
                                id="name" 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                autocomplete="name" 
                                autofocus
                            >
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat Email</label>
                            <input 
                                v-model="email"
                                @change="checkForEmailAvailability()"
                                id="email" 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                :class="{ 'is-invalid': this.email_unavailable }"
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autocomplete="email"
                            >
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kata Sandi</label>
                            <input 
                                id="password" 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" 
                                required 
                                autocomplete="new-password"
                            >
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Kata Sandi</label>
                            <input 
                                id="password-confirm" 
                                type="password" 
                                class="form-control" 
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                            >
                        </div>
                        <button
                            type="submit"
                            class="mt-4 btn btn-primary btn-block"
                            :disabled="this.email_unavailable"
                        >
                            Register Now
                        </button>
                        <a href="{{ route('login') }}" class="mt-2 btn btn-signup btn-block">
                            Back to Login
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      Vue.use(Toasted);

      var register = new Vue({
        el: "#register",
        mounted() {
          AOS.init();
       
        },
        methods: {
            checkForEmailAvailability: function () {
                var self = this;
                axios.get('{{ route('api-register-check') }}', {
                        params: {
                            email: this.email
                        }
                    })
                    .then(function (response) {
                        if(response.data == 'Available') {
                            self.$toasted.show(
                                "Email anda tersedia! Silahkan lanjut langkah selanjutnya!", {
                                    position: "top-center",
                                    className: "rounded",
                                    duration: 1000,
                                }
                            );
                            self.email_unavailable = false;
                        } else {
                            self.$toasted.error(
                                "Maaf, tampaknya email sudah terdaftar pada sistem kami.", {
                                    position: "top-center",
                                    className: "rounded",
                                    duration: 1000,
                                }
                            );
                            self.email_unavailable = true;
                        }
                        // handle success
                        console.log(response.data);
                    })
            }
        },
        data() {
            return {
                name: "",
                email: "",
                is_store_open: false,
                store_name: "",
                email_unavailable: false
            }
        },
      });
    </script>
@endpush
