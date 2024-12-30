import {
  TextControl,
  Flex,
  FlexBlock,
  FlexItem,
  Button,
  Icon,
  PanelBody,
  PanelRow,
  ColorPicker
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
import {
  InspectorControls,
  BlockControls,
  AlignmentToolbar,
  useBlockProps
} from "@wordpress/block-editor";

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
export default function Edit({ attributes, setAttributes }) {
  const blockProps = useBlockProps();

  function deleteAnswer(indexToDelete) {
    const newData = attributes.data.filter(function (x, index) {
      return index != indexToDelete;
    });
    setAttributes({ data: newData });
  }

  return (
    <div {...blockProps}>
      {attributes.data.map(function (answer, index) {
        return (
          <Flex>
            <FlexBlock>
              <TextControl
                autoFocus={answer == undefined}
                value={answer}
                placeholder="Icon"
                onChange={(newValue) => {
                  const newData = attributes.data.concat([]);
                  newData[index] = newValue;
                  setAttributes({ data: newData });
                }}
              />
              <TextControl
                autoFocus={answer == undefined}
                value={answer}
                placeholder="Title"
                onChange={(newValue) => {
                  const newData = attributes.data.concat([]);
                  newData[index] = newValue;
                  setAttributes({ data: newData });
                }}
              />
              <TextControl
                autoFocus={answer == undefined}
                value={answer}
                placeholder="Text"
                onChange={(newValue) => {
                  const newData = attributes.data.concat([]);
                  newData[index] = newValue;
                  setAttributes({ data: newData });
                }}
              />
            </FlexBlock>
            <FlexItem>
              <Button
                isLink
                className="attention-delete"
                onClick={() => deleteAnswer(index)}
              >
                Delete
              </Button>
            </FlexItem>
          </Flex>
        );
      })}
      <Button
        onClick={() => {
          setAttributes({
            data: attributes.data.concat([undefined])
          });
        }}
      >
        Add Benefit
      </Button>
    </div>
  );
}
