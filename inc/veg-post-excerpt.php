<?php


if ( ! class_exists( 'Custom_Excerpt' ) ) {
    class Custom_Excerpt {
        const EXCERPT_LENGTH = 100; // The maximum length of the excerpt

        public function __construct() {
            add_filter( 'wp_insert_post_data', array( $this, 'ensure_excerpt' ), 10, 2 );
        }

        /**
         * Ensure that the post has an excerpt of a specified length.
         *
         * @param array $data An array of slashed, sanitized, and processed post data.
         * @param array $postarr An array of sanitized, but otherwise unmodified post data.
         * @return array Modified post data.
         */
        public function ensure_excerpt( $data, $postarr ) {
            if ( empty( $data['post_excerpt'] ) && ! empty( $data['post_content'] ) ) {
                $data['post_excerpt'] = $this->generate_excerpt( $data['post_content'] );
            } elseif ( ! empty( $data['post_excerpt'] ) ) {
                $data['post_excerpt'] = $this->truncate_excerpt( $data['post_excerpt'] );
            }
            return $data;
        }

        /**
         * Generate an excerpt from the post content.
         *
         * @param string $content The post content.
         * @return string Truncated excerpt.
         */
        private function generate_excerpt( $content ) {
            $excerpt = wp_strip_all_tags( $content );
            return $this->truncate_excerpt( $excerpt );
        }

        /**
         * Truncate the excerpt to the defined length and append ellipsis if necessary.
         *
         * @param string $excerpt The post excerpt.
         * @return string Truncated excerpt.
         */
        private function truncate_excerpt( $excerpt ) {
            if ( mb_strlen( $excerpt ) > self::EXCERPT_LENGTH ) {
                $excerpt = mb_substr( $excerpt, 0, self::EXCERPT_LENGTH ) . '...';
            }
            return $excerpt;
        }
    }

    new Custom_Excerpt();
}