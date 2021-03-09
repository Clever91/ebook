<div>
    <div class="form-group">
        <label for="page_count">Количество страниц</label>
        <input type="number" class="form-control @error('page_count') is-invalid @enderror"
            id="page_count" name="page_count" value="{{ old("page_count") }}"
            placeholder="Введите количество страниц">
        @error('page_count')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
    <div class="form-group">
        <label for="weight">Вес (gram)</label>
        <input type="number" class="form-control @error('weight') is-invalid @enderror"
            id="weight" name="weight" value="{{ old("weight") }}"
            placeholder="Введите вес">
        @error('weight')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
    <div class="form-group">
        <label for="isbn">ISBN</label>
        <input type="text" class="form-control @error('isbn') is-invalid @enderror"
            id="isbn" name="isbn" value="{{ old("isbn") }}"
            placeholder="Введите isbn">
        @error('isbn')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
    <div class="form-group">
        <label for="bar_code">Штрих-код </label>
        <input type="text" class="form-control @error('bar_code') is-invalid @enderror"
            id="bar_code" name="bar_code" value="{{ old("bar_code") }}"
            placeholder="Введите штрих-код ">
        @error('bar_code')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
    <div class="form-group">
        <label for="publisher">Издатель</label>
        <input type="text" class="form-control @error('publisher') is-invalid @enderror"
            id="publisher" name="publisher" value="{{ old("publisher") }}"
            placeholder="Введите издатель">
        @error('publisher')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
    <div class="form-group">
        <label for="year">Год</label>
        <input type="text" class="form-control @error('year') is-invalid @enderror"
            id="year" name="year" value="{{ old("year") }}"
            placeholder="Введите год">
        @error('year')
            <p>{{ __('app.error') }}: <code>{{ $message }}</code></p>
        @enderror
    </div>
</div>
