<svg viewBox="0 0 680 260" xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => 'max-w-full']) }}>
    <defs>
        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#22c55e" />
            <stop offset="100%" stop-color="#0ea5e9" />
        </linearGradient>
    </defs>

    <polygon points="90,50 130,28 170,50 170,94 130,116 90,94"
             fill="none"
             stroke="url(#logoGradient)"
             stroke-width="4" />
    <polygon points="96,54 130,35 164,54 164,90 130,109 96,90"
             fill="url(#logoGradient)"
             opacity="0.16" />
    <path d="M138,44 L122,76 L133,76 L122,108 L148,70 L136,70 Z"
          fill="url(#logoGradient)" />

    <text x="196" y="104"
          font-family="Arial Black, Arial, sans-serif"
          font-weight="900"
          font-size="72"
          letter-spacing="-2"
          fill="white">Fit</text>
    <text x="296" y="104"
          font-family="Arial Black, Arial, sans-serif"
          font-weight="900"
          font-size="72"
          letter-spacing="-2"
          fill="#22c55e">Nexus</text>

    <line x1="197" y1="118" x2="570" y2="118"
          stroke="#22c55e" stroke-width="1.5" opacity="0.4" />
    <circle cx="197" cy="118" r="3" fill="#22c55e" />
    <circle cx="570" cy="118" r="3" fill="#22c55e" />

    <text x="197" y="142"
          font-family="Arial, sans-serif"
          font-size="16"
          letter-spacing="4"
          fill="#22c55e">YOUR FITNESS. YOUR JOURNEY.</text>
</svg>
