// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel :: Heading
// ==========================================================
//
// Marks fixed toolbars for layout while retaining native heading behavior.
//
// ==========================================================

import { h } from "vue"

export default {
  extends: "k-block-type-heading",
  render() {
    return h(
      "div",
      {
        class: [
          "k-block-type-heading-input",
          this.$attrs.class,
          { "zeimoto-blocks-heading-fixed": this.textField.toolbar?.inline === false },
        ],
        style: this.$attrs.style,
        "data-level": this.content.level,
      },
      [
        h("k-writer-input", {
          ref: "input",
          ...this.textField,
          disabled: this.disabled,
          inline: true,
          keys: this.keys,
          value: this.content.text,
          onInput: (value) => this.update({ text: value }),
        }),
        this.levels.length > 1
          ? h("k-input", {
              ref: "level",
              class: "k-block-type-heading-level",
              disabled: this.disabled,
              empty: false,
              options: this.levels,
              value: this.content.level,
              type: "select",
              onInput: (value) => this.update({ level: value }),
            })
          : null,
      ]
    )
  },
}
