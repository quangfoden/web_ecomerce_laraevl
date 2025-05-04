<x-app-layout>
    <div x-data="{
            flashMessage: '{{\Illuminate\Support\Facades\Session::get('flash_message')}}',
            init() {
                if (this.flashMessage) {
                    setTimeout(() => this.$dispatch('notify', {message: this.flashMessage}), 200)
                }
            }
        }" class="container">
        @if (session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif
        <div class="grid-container">
            <div class="form-panel">
                <form x-data="{
                    countries: {{ json_encode($countries) }},
                    billingAddress: {{ json_encode([
                        'address1' => old('billing.address1', $billingAddress->address1),
                        'address2' => old('billing.address2', $billingAddress->address2),
                        'city' => old('billing.city', $billingAddress->city),
                        'state' => old('billing.state', $billingAddress->state),
                        'country_code' => old('billing.country_code', $billingAddress->country_code),
                        'zipcode' => old('billing.zipcode', $billingAddress->zipcode),
                    ]) }},
                    shippingAddress: {{ json_encode([
                        'address1' => old('shipping.address1', $shippingAddress->address1),
                        'address2' => old('shipping.address2', $shippingAddress->address2),
                        'city' => old('shipping.city', $shippingAddress->city),
                        'state' => old('shipping.state', $shippingAddress->state),
                        'country_code' => old('shipping.country_code', $shippingAddress->country_code),
                        'zipcode' => old('shipping.zipcode', $shippingAddress->zipcode),
                    ]) }},
                    get billingCountryStates() {
                        const country = this.countries.find(c => c.code === this.billingAddress.country_code)
                        if (country && country.states) {
                            return JSON.parse(country.states);
                        }
                        return null;
                    },
                    get shippingCountryStates() {
                        const country = this.countries.find(c => c.code === this.shippingAddress.country_code)
                        if (country && country.states) {
                            return JSON.parse(country.states);
                        }
                        return null;
                    }
                }" action="{{ route('profile.update') }}" method="post">
                    @csrf
                    <h2 class="section-title">Thông tin cá nhân</h2>
                    <div class="grid-two-columns">
                        <x-input
                            type="text"
                            name="first_name"
                            value="{{old('first_name', $customer->first_name)}}"
                            placeholder="First Name"
                            class="input-field"
                        />
                        <x-input
                            type="text"
                            name="last_name"
                            value="{{old('last_name', $customer->last_name)}}"
                            placeholder="Last Name"
                            class="input-field"
                        />
                    </div>
                    <div class="input-group">
                        <x-input
                            type="text"
                            name="email"
                            value="{{old('email', $user->email)}}"
                            placeholder="Email"
                            class="input-field"
                        />
                    </div>
                    <div class="input-group">
                        <x-input
                            type="text"
                            name="phone"
                            value="{{old('phone', $customer->phone)}}"
                            placeholder="Phone"
                            class="input-field"
                        />
                    </div>

                    <h2 class="section-title">Địa chỉ thanh toán</h2>
                    <div class="grid-two-columns">
                        <x-input
                            type="text"
                            name="billing[address1]"
                            x-model="billingAddress.address1"
                            placeholder="Địa chỉ 1"
                            class="input-field"
                        />
                        <x-input
                            type="text"
                            name="billing[address2]"
                            x-model="billingAddress.address2"
                            placeholder="Địa chỉ 2"
                            class="input-field"
                        />
                    </div>
                    <div class="grid-two-columns">
                        <x-input
                            type="text"
                            name="billing[city]"
                            x-model="billingAddress.city"
                            placeholder="Quận/Huyện"
                            class="input-field"
                        />
                        <x-input
                            type="text"
                            name="billing[zipcode]"
                            x-model="billingAddress.zipcode"
                            placeholder="Mã bưu chính"
                            class="input-field"
                        />
                    </div>
                    <div class="grid-two-columns">
                        <x-input type="select"
                                 name="billing[country_code]"
                                 x-model="billingAddress.country_code"
                                 class="select-field">
                            <option value="">Chọn quốc gia</option>
                            <template x-for="country of countries" :key="country.code">
                                <option :selected="country.code === billingAddress.country_code"
                                        :value="country.code" x-text="country.name"></option>
                            </template>
                        </x-input>
                        <template x-if="billingCountryStates">
                            <x-input type="select"
                                     name="billing[state]"
                                     x-model="billingAddress.state"
                                     class="select-field">
                                <option value="">Chọn tỉnh/thành phố</option>
                                <template x-for="[code, state] of Object.entries(billingCountryStates)"
                                          :key="code">
                                    <option :selected="code === billingAddress.state"
                                            :value="code" x-text="state"></option>
                                </template>
                            </x-input>
                        </template>
                        <template x-if="!billingCountryStates">
                            <x-input
                                type="text"
                                name="billing[state]"
                                x-model="billingAddress.state"
                                placeholder="Tỉnh/Thành phố"
                                class="input-field"
                            />
                        </template>
                    </div>

                    <div class="section-header">
                        <h2 class="section-title">Địa chỉ nhận hàng</h2>
                        <label for="sameAsBillingAddress" class="checkbox-label">
                            <input @change="$event.target.checked ? shippingAddress = {...billingAddress} : ''"
                                   id="sameAsBillingAddress" type="checkbox"
                                   class="checkbox-input">Giống như thanh toán
                        </label>
                    </div>
                    <div class="grid-two-columns">
                        <x-input
                            type="text"
                            name="shipping[address1]"
                            x-model="shippingAddress.address1"
                            placeholder="Địa chỉ 1"
                            class="input-field"
                        />
                        <x-input
                            type="text"
                            name="shipping[address2]"
                            x-model="shippingAddress.address2"
                            placeholder="Địa chỉ 2"
                            class="input-field"
                        />
                    </div>
                    <div class="grid-two-columns">
                        <x-input
                            type="text"
                            name="shipping[city]"
                            x-model="shippingAddress.city"
                            placeholder="Quận/Huyện"
                            class="input-field"
                        />
                        <x-input
                            type="text"
                            name="shipping[zipcode]"
                            x-model="shippingAddress.zipcode"
                            placeholder="Mã bưu chính"
                            class="input-field"
                        />
                    </div>
                    <div class="grid-two-columns">
                        <x-input type="select"
                                 name="shipping[country_code]"
                                 x-model="shippingAddress.country_code"
                                 class="select-field">
                            <option value="">Chọn quốc gia</option>
                            <template x-for="country of countries" :key="country.code">
                                <option :selected="country.code === shippingAddress.country_code"
                                        :value="country.code" x-text="country.name"></option>
                            </template>
                        </x-input>
                        <template x-if="shippingCountryStates">
                            <x-input type="select"
                                     name="shipping[state]"
                                     x-model="shippingAddress.state"
                                     class="select-field">
                                <option value="">Chọn tỉnh/thành phố</option>
                                <template x-for="[code, state] of Object.entries(shippingCountryStates)"
                                          :key="code">
                                    <option :selected="code === shippingAddress.state"
                                            :value="code" x-text="state"></option>
                                    </template>
                            </x-input>
                        </template>
                        <template x-if="!shippingCountryStates">
                            <x-input
                                type="text"
                                name="shipping[state]"
                                x-model="shippingAddress.state"
                                placeholder="Tỉnh/Thành phố"
                                class="input-field"
                            />
                        </template>
                    </div>

                    <x-button class="primary-button">Cập nhật</x-button>
                </form>
            </div>
            <div class="form-panel">
                <form action="{{route('profile_password.update')}}" method="post">
                    @csrf
                    <h2 class="section-title">Cập nhật mật khẩu</h2>
                    <div class="input-group">
                        <x-input
                            type="password"
                            name="old_password"
                            placeholder="Mật khẩu cũ"
                            class="input-field"
                        />
                    </div>
                    <div class="input-group">
                        <x-input
                            type="password"
                            name="new_password"
                            placeholder="Mật khẩu mới"
                            class="input-field"
                        />
                    </div>
                    <div class="input-group">
                        <x-input
                            type="password"
                            name="new_password_confirmation"
                            placeholder="Xác nhận mật khẩu mới"
                            class="input-field"
                        />
                    </div>
                    <x-button class="primary-button">Cập nhật</x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>