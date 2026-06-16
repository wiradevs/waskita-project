@props(['name', 'label', 'value' => '', 'rows' => 3])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-stone-600 mb-1.5">{{ $label }}</label>
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        style="border:1.5px solid #e2ddd7;border-radius:8px;background:#fdfcfb;padding:9px 12px;font-size:14px;color:#1c1917;width:100%;resize:none;transition:border-color .15s,box-shadow .15s;"
        onfocus="this.style.borderColor='#d97706';this.style.boxShadow='0 0 0 3px rgba(217,119,6,.1)'"
        onblur="this.style.borderColor='#e2ddd7';this.style.boxShadow='none'"
        class="@error($name) !border-red-400 @enderror"
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
    @enderror
</div>
