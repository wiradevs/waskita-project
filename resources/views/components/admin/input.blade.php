@props(['name', 'label', 'value' => '', 'type' => 'text', 'required' => false])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-stone-600 mb-1.5">
        {{ $label }}@if($required)<span class="text-red-400 ml-0.5">*</span>@endif
    </label>
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        style="border:1.5px solid #e2ddd7;border-radius:8px;background:#fdfcfb;transition:border-color .15s,box-shadow .15s;padding:9px 12px;font-size:14px;color:#1c1917;width:100%;"
        onfocus="this.style.borderColor='#d97706';this.style.boxShadow='0 0 0 3px rgba(217,119,6,.1)'"
        onblur="this.style.borderColor='#e2ddd7';this.style.boxShadow='none'"
        class="@error($name) !border-red-400 @enderror"
    >
    @error($name)
        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            {{ $message }}
        </p>
    @enderror
</div>
