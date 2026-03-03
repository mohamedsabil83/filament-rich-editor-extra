import { Extension } from '@tiptap/core'

export default Extension.create({
    name: 'customTextDirection',

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
                (dir, position = null) =>
                    ({commands}) => {
                        if (!dir) {
                            return this.options.types.some((type) => commands.updateAttributes(type, {dir: null}, position))
                        }

                        if (!['ltr', 'rtl', 'auto'].includes(dir)) {
                            return false
                        }

                        return this.options.types.some((type) => commands.updateAttributes(type, {dir}, position))
                    },
            unsetTextDirection:
                (position = null) =>
                    ({commands}) =>
                        this.options.types.some((type) => commands.updateAttributes(type, {dir: null}, position)),
        }
    },
})
