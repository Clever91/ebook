@php
use App\Models\Admin\Book;
@endphp
<div>
    <div class="form-group">
        <label for="price">Цена</label>
        <input type="text" class="form-control @error('price') is-invalid @enderror"
            id="price" name="price" value="{{ old("price") }}"
            placeholder="Введите цена" required>
        @error('price')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
    {{-- ~~~~~~~~~~~~~~~~~~~ Optional params ~~~~~~~~~~~~~~~~~~~ --}}
    <div class="form-group">
        <label for="leftover">Остатки</label>
        <input type="text" class="form-control @error('leftover') is-invalid @enderror"
            id="leftover" name="leftover" value="{{ old("leftover") }}"
            placeholder="Введите остаток">
        @error('leftover')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
    <div class="form-group">
        <label for="cover_type_id">Обложка книги</label>
        <select class="form-control select2bs4 @error('cover_type_id') is-invalid @enderror"
            name="cover_type_id" style="width: 100%;" required>
            {{-- <option>Выберите обложка</option> --}}
            @foreach (Book::coverTypes() as $cover)
                @if (old('cover_type_id') == $cover->id)
            <option value="{{ $cover->id }}" selected>{{ $cover->translateOrNew(\App::getLocale())->name }}</option>
                @else
            <option value="{{ $cover->id }}">{{ $cover->translateOrNew(\App::getLocale())->name }}</option>
                @endif
            @endforeach
        </select>
        @error('cover_type_id')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
    <div class="form-group">
        <label for="letter">Надпись</label>
        <select class="form-control select2bs4 @error('letter') is-invalid @enderror"
            name="letter" style="width: 100%;">
            <option value="">Выберите</option>
            @foreach (Book::letterTypes() as $letter => $val)
                @if (old('letter') == $letter)
            <option value="{{ $letter }}" selected>{{ $val }}</option>
                @else
            <option value="{{ $letter }}">{{ $val }}</option>
                @endif
            @endforeach
        </select>
        @error('letter')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
    <div class="form-group">
        <label for="paper_size">Размер страницы</label>
        <input type="text" class="form-control @error('paper_size') is-invalid @enderror"
            id="paper_size" name="paper_size"  value="{{ old('paper_size') }}"
            placeholder="Введите размер">
        @error('paper_size')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
    <div class="form-group">
        <label for="color_id">Цвет книги</label>
        <select class="form-control select2bs4 @error('color_id') is-invalid @enderror"
            name="color_id" style="width: 100%;">
            <option value="">Выберите цвет</option>
            @foreach (Book::colorTypes() as $color)
                @if (old('color_id') == $color->id)
            <option value="{{ $color->id }}" selected>{{ $color->name }}</option>
                @else
            <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endif
            @endforeach
        </select>
        @error('color_id')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
</div>
