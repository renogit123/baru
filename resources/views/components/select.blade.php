<select {{ $attributes->merge(['class' => 'border rounded w-full px-3 py-2']) }}>
    <option value="">{{ $placeholder ?? '-- Pilih --' }}</option>
    @foreach($options as $item)
        <option value="{{ $item->id }}">{{ $item->nama }}</option>
    @endforeach
</select>
