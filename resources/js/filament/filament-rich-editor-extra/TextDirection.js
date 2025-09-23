import { Extension } from '@tiptap/core'

export default Extension.create({
    name: 'textDirection',

    addOptions() {
        return {
            types: ['paragraph', 'heading'],
        }
    },

    addGlobalAttributes() {
        return [
            {
                types: this.options.types,
                attributes: {
                    dir: {
                        default: null,
                        parseHTML: element => ({dir: element.getAttribute('dir')}),
                        renderHTML: attributes => {
                            if (!attributes.dir) {
                                return {}
                            }
                            return {dir: attributes.dir}
                        },
                    },
                },
            },
        ]
    },

    addCommands() {
        return {
            setTextDirection:
                (dir) =>
                    ({commands}) => {
                        if (!dir) {
                            return (
                                commands.updateAttributes('paragraph', {dir: null}) ||
                                commands.updateAttributes('heading', {dir: null})
                            )
                        }

                        if (!['ltr', 'rtl'].includes(dir)) {
                            return false
                        }

                        const updatedParagraph = commands.updateAttributes('paragraph', {dir})
                        const updatedHeading = commands.updateAttributes('heading', {dir})

                        return updatedParagraph || updatedHeading
                    },
            unsetTextDirection:
                () =>
                    ({commands}) =>
                        commands.updateAttributes('paragraph', {dir: null}) ||
                        commands.updateAttributes('heading', {dir: null}),
        }
    },
})
