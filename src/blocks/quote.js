// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel :: Quote
// ==========================================================
//
// Extends Kirby's native quote block editor with zeimoto's
// attribution metadata while preserving the core editing flow.
//
// ==========================================================

import { h } from "vue"

export default {
  extends: "k-block-type-quote",
  computed: {
    roleField() {
      return this.field("role", {})
    },
    sourceField() {
      return this.field("source", {})
    },
  },
  render() {
    return h(
      "div",
      {
        class: [
          "k-block-type-quote-editor",
          { "zeimoto-blocks-quote-fixed": this.textField.toolbar?.inline === false },
        ],
      },
      [
        h("k-writer-input", {
          ref: "text",
          class: "k-block-type-quote-text",
          disabled: this.disabled,
          inline: this.textField.inline ?? false,
          marks: this.textField.marks,
          nodes: this.textField.nodes,
          toolbar: this.textField.toolbar ?? { inline: true },
          placeholder: this.textField.placeholder,
          value: this.content.text,
          onInput: (value) => this.update({ text: value }),
        }),
        h(
          "div",
          { class: "k-block-type-quote-grid" },
          [
            ["citation", "k-text-input", this.citationField],
            ["role", "k-text-input", this.roleField],
            ["source", "k-url-input", this.sourceField],
          ].map(([name, component, field]) =>
            h(component, {
              ref: name,
              class: `k-block-type-quote-${name}`,
              disabled: this.disabled,
              placeholder: field.placeholder,
              value: this.content[name],
              onInput: (value) => this.update({ [name]: value }),
            })
          )
        ),
      ]
    )
  },
}
