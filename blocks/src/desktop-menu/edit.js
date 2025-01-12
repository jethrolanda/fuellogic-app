import { store as coreDataStore } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";
import {
  PanelBody,
  SelectControl,
  Spinner,
  TextControl
} from "@wordpress/components";

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from "@wordpress/block-editor";

function useCustomPatternBlocks(props) {
  const { patterns, hasResolved } = useSelect(
    (select) => {
      const selectorArgs = ["postType", "wp_block", { per_page: -1 }];

      return {
        patterns: select(coreDataStore).getEntityRecords(...selectorArgs),
        hasResolved: select(coreDataStore).hasFinishedResolution(
          "getEntityRecords",
          selectorArgs
        )
      };
    },
    [props]
  );

  return { patterns, hasResolved };
}

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit(props) {
  const { patterns, hasResolved } = useCustomPatternBlocks(props);
  const options = patterns
    ? patterns.map((p) => {
        return { value: p.id, label: p.title.raw };
      })
    : [];
  options.unshift({ value: "none", label: "Select a Pattern" });
  const blockProps = useBlockProps();
  const { attributes, setAttributes } = props;
  const { mobileMenuPattern } = attributes;

  function onChangeMobileMenuPattern(value) {
    setAttributes({ mobileMenuPattern: value });
  }

  return (
    <div {...blockProps}>
      <InspectorControls>
        <PanelBody title="Settings" initialOpen={true}>
          {hasResolved ? (
            <>
              <SelectControl
                label="Desktop Menu Pattern"
                value={
                  parseInt(mobileMenuPattern) > 0 ? mobileMenuPattern : "none"
                }
                options={options}
                onChange={onChangeMobileMenuPattern}
              />
            </>
          ) : (
            <div style={{ marginBottom: "10px" }}>
              Loading Patterns
              <Spinner />
            </div>
          )}
        </PanelBody>
      </InspectorControls>
      <div>FL Desktop Menu</div>
    </div>
  );
}
