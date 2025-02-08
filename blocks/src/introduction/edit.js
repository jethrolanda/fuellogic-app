import { useEffect, useState, useRef } from "@wordpress/element";
import {
  TextControl,
  TextareaControl,
  Flex,
  FlexBlock,
  FlexItem,
  Button,
  Icon,
  PanelBody,
  PanelRow,
  ColorPicker,
  __experimentalText as Text,
  __experimentalVStack as VStack,
  BaseControl,
  Toolbar,
  ToolbarButton
} from "@wordpress/components";

import { edit, update } from "@wordpress/icons";
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
  useBlockProps,
  MediaUpload,
  MediaUploadCheck
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
  const ref = useRef();
  const blockProps = useBlockProps({ ref });

  const ALLOWED_MEDIA_TYPES = ["image"]; // 'image', 'audio', 'text', or the complete mime type e.g: 'audio/mpeg', 'image/gif'
  const { editMode } = attributes;

  function deleteAnswer(indexToDelete) {
    const newData = attributes.data.filter(function (x, index) {
      return index != indexToDelete;
    });
    setAttributes({ data: newData });
  }

  function toggleEditMode() {
    setAttributes({ editMode: !editMode });
  }

  // useEffect(() => {
  //   const { ownerDocument } = ref.current;
  //   const { defaultView } = ownerDocument;
  //   // Set ownerDocument.title for example.
  // }, []);

  useEffect(() => {
    const { ownerDocument } = ref.current;

    if (attributes?.data?.length > 0) {
      ownerDocument.body.style.backgroundImage =
        "url('" + attributes?.data?.[0]?.bg_image?.url + "')";
      ownerDocument.body.style.backgroundSize = "cover";
      ownerDocument.body.style.backgroundPosition = "center top";
      ownerDocument.body.style.backgroundRepeat = "no-repeat";
    }
  }, [attributes?.data]);

  return (
    <div {...blockProps}>
      <BlockControls>
        {editMode ? (
          <ToolbarButton
            icon={update}
            label="View"
            onClick={() => toggleEditMode()}
          />
        ) : (
          <ToolbarButton
            icon={edit}
            label="Edit"
            onClick={() => toggleEditMode()}
          />
        )}
      </BlockControls>
      {editMode ? (
        <Flex>
          <FlexBlock style={{ gap: "20px" }}>
            {attributes.data.map(function (benefit, index) {
              return (
                <div>
                  <h4>Benefit #{index + 1}</h4>
                  <BaseControl help="Only class name example: fa-solid fa-map">
                    <BaseControl.VisualLabel>
                      Fontawesome Class
                    </BaseControl.VisualLabel>
                    <TextControl
                      value={benefit?.fa_class}
                      onChange={(newValue) => {
                        const newData = attributes.data.concat([]);
                        newData[index] = {
                          ...newData[index],
                          fa_class: newValue
                        };
                        setAttributes({ data: newData });
                      }}
                    />
                  </BaseControl>

                  <BaseControl>
                    <BaseControl.VisualLabel>Heading</BaseControl.VisualLabel>
                    <TextControl
                      value={benefit?.heading}
                      onChange={(newValue) => {
                        const newData = attributes.data.concat([]);
                        newData[index] = {
                          ...newData[index],
                          heading: newValue
                        };
                        setAttributes({ data: newData });
                      }}
                    />
                  </BaseControl>

                  <BaseControl>
                    <TextareaControl
                      value={benefit?.excerpt}
                      label="Excerpt"
                      onChange={(newValue) => {
                        const newData = attributes.data.concat([]);
                        newData[index] = {
                          ...newData[index],
                          excerpt: newValue
                        };
                        setAttributes({ data: newData });
                      }}
                    />
                  </BaseControl>

                  <BaseControl help="Select background image">
                    <BaseControl.VisualLabel>
                      Background Image
                    </BaseControl.VisualLabel>

                    <MediaUploadCheck>
                      <MediaUpload
                        onSelect={(media) => {
                          const newData = attributes.data.concat([]);
                          newData[index] = {
                            ...newData[index],
                            bg_image: media
                          };
                          setAttributes({ data: newData });
                        }}
                        allowedTypes={ALLOWED_MEDIA_TYPES}
                        // value={mediaId}
                        render={({ open }) => (
                          <a onClick={open} className="custom-btn btn-media">
                            Open Media Library
                          </a>
                        )}
                      />
                    </MediaUploadCheck>
                    {attributes.data[index]?.bg_image?.sizes?.thumbnail
                      ?.url && (
                      <img
                        src={
                          attributes.data[index]?.bg_image?.sizes?.thumbnail
                            ?.url
                        }
                      />
                    )}
                  </BaseControl>

                  <BaseControl>
                    <a
                      className="custom-btn btn-delete"
                      onClick={() => deleteAnswer(index)}
                    >
                      Remove Benefit
                    </a>
                  </BaseControl>
                </div>
              );
            })}
            <a
              className="custom-btn btn-add"
              onClick={() => {
                setAttributes({
                  data: attributes.data.concat([undefined])
                });
              }}
            >
              Add New Benefit
            </a>
          </FlexBlock>
        </Flex>
      ) : (
        <IntroductionBlock data={attributes.data} />
      )}
    </div>
  );
}

function IntroductionBlock(props) {
  const { data } = props;

  const benefits = data.map((benefit, index) => {
    return (
      <>
        <div class={`slider slide-${index} ${index === 0 ? "active" : ""} `}>
          <i class={`icon ${benefit?.fa_class}`}></i>
          <h1>{benefit?.heading}</h1>
          <p>{benefit?.excerpt}</p>
        </div>
      </>
    );
  });

  const nav = data.map((benefit, index) => {
    return <li class={` ${index === 0 ? "active" : ""}`}></li>;
  });

  return (
    <>
      {benefits}
      <ul>{nav}</ul>
      <button data-wp-on--click="actions.next">
        <span data-wp-text="context.next">Next</span>{" "}
        <i class="fa-solid fa-arrow-right"></i>
      </button>
    </>
  );
}
