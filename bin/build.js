import * as esbuild from 'esbuild'

async function compile(options) {
    const context = await esbuild.context(options)

    await context.rebuild()
    await context.dispose()
}

const defaultOptions = {
    define: {
        'process.env.NODE_ENV': `'production'`,
    },
    bundle: true,
    mainFields: ['module', 'main'],
    platform: 'neutral',
    sourcemap: false,
    sourcesContent: false,
    treeShaking: true,
    target: ['es2020'],
    minify: true,
}

const entryPoints = [
    {
        in: './resources/js/filament/filament-rich-editor-extra/TextDirection.js',
        out: './resources/js/dist/filament/filament-rich-editor-extra/TextDirection.js',
    },
    {
        in: './resources/js/filament/filament-rich-editor-extra/Emoji.js',
        out: './resources/js/dist/filament/filament-rich-editor-extra/Emoji.js',
    },
    {
        in: './resources/js/filament/filament-rich-editor-extra/Fullscreen.js',
        out: './resources/js/dist/filament/filament-rich-editor-extra/Fullscreen.js',
    },
    {
        in: './resources/js/filament/filament-rich-editor-extra/StickyToolbar.js',
        out: './resources/js/dist/filament/filament-rich-editor-extra/StickyToolbar.js',
    },
]

entryPoints.forEach(({ in: entryPoint, out: outfile }) =>
    compile({
        ...defaultOptions,
        entryPoints: [entryPoint],
        outfile,
    }),
)
