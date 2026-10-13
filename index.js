(function(){"use strict";const e={extends:"k-block-type-quote",computed:{roleField(){return this.field("role",{})},sourceField(){return this.field("source",{})}},template:`
    <div class="k-block-type-quote-editor">
      <k-writer-input
        ref="text"
        :disabled="disabled"
        :inline="textField.inline ?? false"
        :marks="textField.marks"
        :nodes="textField.nodes"
        :placeholder="textField.placeholder"
        :value="content.text"
        class="k-block-type-quote-text"
        @input="update({ text: $event })"
      />
      <div class="k-block-type-quote-grid">
        <k-text-input
          ref="citation"
          :disabled="disabled"
          :placeholder="citationField.placeholder"
          :value="content.citation"
          class="k-block-type-quote-citation"
          @input="update({ citation: $event })"
        />
        <k-text-input
          ref="role"
          :disabled="disabled"
          :placeholder="roleField.placeholder"
          :value="content.role"
          class="k-block-type-quote-role"
          @input="update({ role: $event })"
        />
        <k-url-input
          ref="source"
          :disabled="disabled"
          :placeholder="sourceField.placeholder"
          :value="content.source"
          class="k-block-type-quote-source"
          @input="update({ source: $event })"
        />
      </div>
    </div>
  `};panel.plugin("zeimoto/blocks",{components:{"k-block-type-quote":e}})})();
