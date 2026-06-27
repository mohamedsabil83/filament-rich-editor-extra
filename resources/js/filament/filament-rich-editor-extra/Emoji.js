import { Extension } from '@tiptap/core'
import { Picker } from 'emoji-picker-element'

// Emojis are inserted as plain Unicode characters (e.g. 😀) via core Tiptap's
// `insertContent`, so there is no custom node or mark to render — the character
// lives in the document as ordinary text and survives server-side rendering
// untouched.
//
// `emoji-picker-element` provides the full mobile/social-style picker (search,
// categories, skin tones, the complete Unicode emoji set). Its data is loaded
// once from a CDN and cached in the browser's IndexedDB. The extension owns the
// floating popup so the toolbar button only has to call `openEmojiPicker(button)`.

const MOBILE_BREAKPOINT = 480
const MARGIN = 8

let activePopup = null
let activeAnchor = null

function closePopup() {
    if (!activePopup) {
        return
    }

    document.removeEventListener('click', onDocumentClick, true)
    document.removeEventListener('keydown', onKeyDown, true)
    window.removeEventListener('resize', reposition)
    window.removeEventListener('scroll', reposition, true)

    activePopup.remove()
    activePopup = null
    activeAnchor = null
}

function onDocumentClick(event) {
    // Ignore clicks on the toolbar button itself — its own handler toggles the
    // picker. Events from inside the picker's shadow DOM are retargeted to the
    // host <emoji-picker> element, so `contains` still resolves to the popup.
    if (
        activePopup &&
        !activePopup.contains(event.target) &&
        !(activeAnchor && activeAnchor.contains(event.target))
    ) {
        closePopup()
    }
}

function onKeyDown(event) {
    if (event.key === 'Escape') {
        closePopup()
    }
}

function reposition() {
    if (activePopup && activeAnchor) {
        positionPopup(activePopup, activeAnchor)
    }
}

function positionPopup(popup, anchor) {
    const picker = popup.firstElementChild
    const isMobile = window.innerWidth <= MOBILE_BREAKPOINT

    if (isMobile) {
        // Bottom sheet — full width, pinned to the bottom edge, like a native
        // mobile picker.
        picker.style.width = '100%'
        picker.style.height = `${Math.min(400, Math.round(window.innerHeight * 0.6))}px`

        Object.assign(popup.style, {
            left: '0px',
            right: '0px',
            bottom: '0px',
            top: 'auto',
        })

        return
    }

    picker.style.width = '352px'
    picker.style.height = `${Math.min(400, window.innerHeight - 2 * MARGIN)}px`

    popup.style.right = 'auto'
    popup.style.bottom = 'auto'

    const rect = anchor.getBoundingClientRect()
    const width = popup.offsetWidth
    const height = popup.offsetHeight

    // Stack the popup directly beneath the button; flip above it when there is
    // not enough room below.
    let top = rect.bottom + MARGIN

    if (top + height > window.innerHeight - MARGIN) {
        const flipped = rect.top - height - MARGIN

        top = flipped >= MARGIN ? flipped : Math.max(MARGIN, window.innerHeight - height - MARGIN)
    }

    // Align to the button's left edge, then clamp inside the viewport.
    let left = Math.min(rect.left, window.innerWidth - width - MARGIN)
    left = Math.max(MARGIN, left)

    popup.style.left = `${left}px`
    popup.style.top = `${top}px`
}

function openPicker(editor, anchor) {
    // Toggle: a second click on the toolbar button closes an open picker.
    if (activePopup) {
        closePopup()

        return
    }

    if (!anchor) {
        return
    }

    const popup = document.createElement('div')
    Object.assign(popup.style, {
        position: 'fixed',
        zIndex: '99999',
        boxShadow: '0 10px 25px rgba(0, 0, 0, 0.15)',
        borderRadius: '0.75rem',
        overflow: 'hidden',
    })

    const picker = new Picker()
    picker.style.maxWidth = '100vw'

    // Follow Filament's dark mode, which toggles a `dark` class on <html>.
    picker.classList.add(document.documentElement.classList.contains('dark') ? 'dark' : 'light')

    picker.addEventListener('emoji-click', (event) => {
        editor.chain().focus().insertEmoji(event.detail.unicode).run()
        closePopup()
    })

    popup.appendChild(picker)
    document.body.appendChild(popup)

    activePopup = popup
    activeAnchor = anchor

    positionPopup(popup, anchor)

    // Defer the listeners so the click that opened the picker doesn't close it.
    setTimeout(() => {
        document.addEventListener('click', onDocumentClick, true)
        document.addEventListener('keydown', onKeyDown, true)
        window.addEventListener('resize', reposition)
        window.addEventListener('scroll', reposition, true)
    }, 0)
}

export default Extension.create({
    name: 'customEmoji',

    addCommands() {
        return {
            insertEmoji:
                (emoji) =>
                ({ commands }) =>
                    commands.insertContent(emoji),

            openEmojiPicker:
                (anchor) =>
                ({ editor }) => {
                    openPicker(editor, anchor)

                    return true
                },
        }
    },
})
