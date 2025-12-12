@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>Contact</h2>
    </div>
    <form class="form" action="{{ route('contacts.confirm') }}" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="name-inputs">
                    <div class="name-field">
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="例：山田">
                    </div>
                    <div class="name-field">
                        <input type="text" name="first_name" value="{{ old('first_name') }}"placeholder="例：太郎">
                    </div>
                </div>
                <div class="form__error">
                    @error('last_name')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form__error">
                    @error('first_name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">性別</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__select--radio">
                    <input type="radio"  name="gender" value="1" {{ old('gender') === '1' ? 'checked' : '' }}>
                    <label for="Choice1">男性</label>
                    <input type="radio" name="gender" value="2" {{ old('gender') === '2' ? 'checked' : '' }}>
                    <label for="Choice2">女性</label>
                    <input type="radio" name="gender" value="3" {{ old('gender') === '3' ? 'checked' : '' }}>
                    <label for="Choice3">その他</label>
                </div>
                <div class="form__error">
                    @error('gender')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="test@example.com" />
                </div>
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">電話番号</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="tel" name="tel1" maxlength="5" value="{{ old('tel1') }}" placeholder="080">
                    <span>-</span>
                    <input type="tel" name="tel2" maxlength="5" value="{{ old('tel2') }}" placeholder="1234">
                    <span>-</span>
                    <input type="tel" name="tel3" maxlength="5" value="{{ old('tel3') }}" placeholder="5678">
                </div>
                <div class="form__error">
                    @error('tel1')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form__error">
                    @error('tel2')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form__error">
                    @error('tel3')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">住所</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="東京都渋谷区千駄ヶ谷1-2-3">
                </div>
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="building" value="{{ old('building') }}" placeholder="千駄ヶ谷マンション101">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせの種類</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__select--pulldown">
                    <select name="category_id">
                        <option value="" hidden>選択してください</option>
                        <option value="1" {{ old('category_id') === '1' ? 'selected' : '' }}>1.商品のお届けについて</option>
                        <option value="2" {{ old('category_id') === '2' ? 'selected' : '' }}>2.商品の交換について</option>
                        <option value="3" {{ old('category_id') === '3' ? 'selected' : '' }}>3.商品トラブル</option>
                        <option value="4" {{ old('category_id') === '4' ? 'selected' : '' }}>4.ショップへのお問い合わせ</option>
                        <option value="5" {{ old('category_id') === '5' ? 'selected' : '' }}>5.その他</option>
                    </select>
                </div>
                <div class="form__error">
                    @error('category_id')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせ内容</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--textarea">
                    <textarea name="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                </div>
                <div class="form__error">
                    @error('detail')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </form>
</div>
@endsection
