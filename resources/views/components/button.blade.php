<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-[2rem] py-[0.75rem] bg-[#FEA116] rounded-[5px] font-semibold text-[12px] text-white hover:bg-[#d48613] focus:bg-[#d48613] focus:outline-none transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
