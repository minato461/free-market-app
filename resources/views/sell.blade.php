<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品出品 | フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
</head>
<body>

    <div class="page-container">
        <header class="header">
            <div class="header__inner">
                <h1 class="header__logo">
                    <a href="{{ route('item.index') }}">
                        <img src="{{ asset('storage/image/logo.svg') }}" alt="COACHTECH">
                    </a>
                </h1>
                <nav class="header__nav">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="logout__button nav__link">ログアウト</button>
                            </form>
                        </li>
                        <li class="nav__item"><a href="{{ route('mypage.index') }}">マイページ</a></li>
                        <li class="nav__item"><a href="{{ route('item.create') }}" class="sell__button">出品</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="main sell-main">
            <h2 class="sell-title">商品の出品</h2>

            <form class="sell-form" action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="sell-section image-section">
                    <p class="section-title">商品画像</p>
                    <div class="image-upload-box" id="image-upload-box">
                        <label for="item_image_upload" class="image-select-button">画像を選択する</label>
                        <input type="file" id="item_image_upload" name="item_image" style="display: none;" accept="image/*">
                        <div id="preview-container"></div>
                    </div>
                    @error('item_image') <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p> @enderror
                </div>

                <div class="sell-divider"></div>

                <div class="sell-section details-section">
                    <p class="section-title">商品の詳細</p>

                    <div class="form-group category-group">
                        <label class="form-label">カテゴリ</label>
                        <div class="category-tags" id="category-tag-list">
                            @php
                                $categoryList = [
                                    ['id' => 1, 'name' => 'ファッション'],
                                    ['id' => 2, 'name' => '家電'],
                                    ['id' => 3, 'name' => 'インテリア'],
                                    ['id' => 4, 'name' => 'レディース'],
                                    ['id' => 5, 'name' => 'メンズ'],
                                    ['id' => 6, 'name' => 'コスメ'],
                                    ['id' => 7, 'name' => '本'],
                                    ['id' => 8, 'name' => 'ゲーム'],
                                    ['id' => 9, 'name' => 'スポーツ'],
                                    ['id' => 10, 'name' => 'キッチン'],
                                    ['id' => 11, 'name' => 'ハンドメイド'],
                                    ['id' => 12, 'name' => 'アクセサリー'],
                                    ['id' => 13, 'name' => 'おもちゃ'],
                                    ['id' => 14, 'name' => 'ベビー・キッズ'],
                                ];
                            @endphp
                            @foreach($categoryList as $cat)
                                <span class="category-tag {{ collect(old('category_ids'))->contains($cat['id']) ? 'is-selected' : '' }}" 
                                    data-id="{{ $cat['id'] }}">
                                    {{ $cat['name'] }}
                                </span>
                            @endforeach
                        </div>
                        <div id="hidden-category-inputs">
                            @if(old('category_ids'))
                                @foreach(old('category_ids') as $oldId)
                                    <input type="hidden" name="category_ids[]" value="{{ $oldId }}">
                                @endforeach
                            @endif
                        </div>
                        @error('category_ids') <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="condition" class="form-label">商品の状態</label>
                        <select id="condition" name="condition" class="form-select">
                            <option value="">選択してください</option>
                            <option value="良好" {{ old('condition') == '良好' ? 'selected' : '' }}>良好</option>
                            <option value="目立った傷や汚れなし" {{ old('condition') == '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                            <option value="やや傷や汚れあり" {{ old('condition') == 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                            <option value="状態が悪い" {{ old('condition') == '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
                        </select>
                        @error('condition') <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="sell-divider"></div>

                <div class="sell-section name-description-section">
                    <p class="section-title">商品名と説明</p>
                    <div class="form-group">
                        <label for="name" class="form-label">商品名</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}">
                        @error('name') <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="brand_name" class="form-label">ブランド名</label>
                        <input type="text" id="brand_name" name="brand_name" class="form-input" value="{{ old('brand_name') }}">
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">商品の説明</label>
                        <textarea id="description" name="description" class="form-textarea">{{ old('description') }}</textarea>
                        @error('description') <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="sell-divider"></div>

                <div class="sell-section price-section">
                    <p class="section-title">販売価格</p>
                    <div class="form-group price-group">
                        <input type="number" id="price" name="price" class="form-input price-input" placeholder="¥" value="{{ old('price') }}">
                    </div>
                    @error('price') <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p> @enderror
                </div>

                <div class="sell-divider"></div>

                <button type="submit" class="sell-button">出品する</button>
            </form>
        </main>
    </div>

    <script>
        document.getElementById('item_image_upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const container = document.getElementById('preview-container');
            container.innerHTML = '';

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.style.width = '150px';
                    img.style.marginTop = '15px';
                    img.style.borderRadius = '5px';
                    container.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });

        // カテゴリタグ選択処理
        const tags = document.querySelectorAll('.category-tag');
        const hiddenContainer = document.getElementById('hidden-category-inputs');

        tags.forEach(tag => {
            tag.addEventListener('click', function() {
                this.classList.toggle('is-selected');

                hiddenContainer.innerHTML = '';
                document.querySelectorAll('.category-tag.is-selected').forEach(selectedTag => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'category_ids[]';
                    input.value = selectedTag.dataset.id;
                    hiddenContainer.appendChild(input);
                });
            });
        });
    </script>
</body>
</html>