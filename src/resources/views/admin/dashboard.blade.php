@extends('layouts.app-auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')

<div class="admin-logout">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="admin-logout__button">logout</button>
    </form>
</div>

<div class="admin-heading">
    <h2>Admin</h2>
</div>

<div class="admin-wrapper">

    <form method="GET" action="{{ route('dashboard') }}" class="admin-search">
        <div class="admin-search__row">
            <div class="admin-search__item">
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="名前やメールアドレスを入力してください"
                >
            </div>
            <div class="admin-search__item select-wrapper">
                <select name="gender">
                    <option value="">性別</option>
                    <option value="1" {{ request('gender') === '1' ? 'selected' : '' }}>男性</option>
                    <option value="2" {{ request('gender') === '2' ? 'selected' : '' }}>女性</option>
                    <option value="3" {{ request('gender') === '3' ? 'selected' : '' }}>その他</option>
                </select>
            </div>
            <div class="admin-search__item select-wrapper">
                <select name="category_id">
                    <option value="">お問い合わせの種類</option>
                    <option value="1" {{ request('category_id') === '1' ? 'selected' : '' }}>商品のお届けについて</option>
                    <option value="2" {{ request('category_id') === '2' ? 'selected' : '' }}>商品の交換について</option>
                    <option value="3" {{ request('category_id') === '3' ? 'selected' : '' }}>商品トラブル</option>
                    <option value="4" {{ request('category_id') === '4' ? 'selected' : '' }}>ショップへのお問い合わせ</option>
                    <option value="5" {{ request('category_id') === '5' ? 'selected' : '' }}>その他</option>
                </select>
            </div>
            <div class="admin-search__item">
                <input
                    type="date"
                    name="created_at"
                    value="{{ request('created_at') }}"
                >
            </div>
            <div class="admin-search__item admin-search__buttons">
                <button type="submit" class="admin-search__button--primary">検索</button>
                <a href="{{ route('dashboard') }}" class="admin-search__button--reset">リセット</a>
            </div>
        </div>
    </form>
<div class="admin-export">
    <a href="{{ route('dashboard.export', request()->query()) }}" class="admin-export__button">
        エクスポート
    </a>
</div>

<div class="admin-table">
    <div class="pagination-wrapper">
        {{ $contacts->links('vendor.pagination.custom') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
                @php
                    $genderLabel = [
                        1 => '男性',
                        2 => '女性',
                        3 => 'その他',
                    ];
                    $categoryLabel = [
                        1 => '商品のお届けについて',
                        2 => '商品の交換について',
                        3 => '商品トラブル',
                        4 => 'ショップへのお問い合わせ',
                        5 => 'その他',
                    ];
                @endphp
                <tr>
                    <td>{{ $contact->last_name }}　{{ $contact->first_name }}</td>
                    <td>{{ $genderLabel[$contact->gender] ?? '' }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $categoryLabel[$contact->category_id] ?? '' }}</td>
                    <td class="admin-table__action">
                        <button type="button"
                            class="admin-table__detail-button"
                            data-contact='@json($contact)'
                            data-delete-url="{{ route('admin.contacts.destroy', $contact) }}"
                        >
                            詳細
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="admin-table__empty">該当するお問い合わせはありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="modalOverlay" class="modal-overlay"></div>

<div id="contactModal" class="modal">
    <button type="button" id="modalClose" class="modal__close">&times;</button>

    <div class="modal__body">
        <table class="modal-table">
            <tr>
                <th>お名前</th>
                <td id="modalName"></td>
            </tr>
            <tr>
                <th>性別</th>
                <td id="modalGender"></td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td id="modalEmail"></td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td id="modalTel"></td>
            </tr>
            <tr>
                <th>住所</th>
                <td id="modalAddress"></td>
            </tr>
            <tr>
                <th>建物名</th>
                <td id="modalBuilding"></td>
            </tr>
            <tr>
                <th>お問い合わせの種類</th>
                <td id="modalCategory"></td>
            </tr>
            <tr>
                <th>お問い合わせ内容</th>
                <td id="modalDetail"></td>
            </tr>
        </table>

        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="submit" class="modal__delete-button">削除</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const overlay    = document.getElementById('modalOverlay');
    const modal      = document.getElementById('contactModal');
    const closeBtn   = document.getElementById('modalClose');
    const deleteForm = document.getElementById('deleteForm');

    const genderMap = {
        1: '男性',
        2: '女性',
        3: 'その他',
    };

    const categoryMap = {
        1: '商品のお届けについて',
        2: '商品の交換について',
        3: '商品トラブル',
        4: 'ショップへのお問い合わせ',
        5: 'その他',
    };

    function openModal(contact, deleteUrl) {
        document.getElementById('modalName').textContent =
            (contact.last_name ?? '') + '　' + (contact.first_name ?? '');
        document.getElementById('modalGender').textContent =
            genderMap[contact.gender] ?? '';
        document.getElementById('modalEmail').textContent = contact.email ?? '';
        document.getElementById('modalTel').textContent = contact.tel ?? '';
        document.getElementById('modalAddress').textContent = contact.address ?? '';
        document.getElementById('modalBuilding').textContent = contact.building ?? '';
        document.getElementById('modalCategory').textContent =
            categoryMap[contact.category_id] ?? '';
        document.getElementById('modalDetail').textContent = contact.detail ?? '';

        deleteForm.action = deleteUrl;

        overlay.classList.add('is-show');
        modal.classList.add('is-show');
    }

    function closeModal() {
        overlay.classList.remove('is-show');
        modal.classList.remove('is-show');
    }

    document.querySelectorAll('.admin-table__detail-button').forEach(function (button) {
        button.addEventListener('click', function () {
            const contact   = JSON.parse(button.dataset.contact);
            const deleteUrl = button.dataset.deleteUrl;
            openModal(contact, deleteUrl);
        });
    });

    overlay.addEventListener('click', closeModal);
    closeBtn.addEventListener('click', closeModal);
});
</script>

@endsection
