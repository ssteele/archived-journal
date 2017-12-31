<?php
namespace App\Services\Annotation;

use App\Entry;
use App\EntryHasMention;
use App\EntryHasTag;
use App\Marker;
use App\Mention;
use App\Tag;
use App\User;

class Handler
{
    /** @var integer */
    private $userId;

    /** @var integer */
    private $entryId;

    /** @var string */
    private $entryText;

    /** @var array */
    private $tags = [];

    /** @var array */
    private $mentions = [];

    /** @var array */
    private $markers = [];

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setEntryId($entryId)
    {
        $this->entryId = $entryId;
    }

    public function getEntryId()
    {
        return $this->entryId;
    }

    public function setEntryText($entryText)
    {
        $this->entryText = $entryText;
    }

    public function getEntryText()
    {
        return $this->entryText;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setMentions($mentions)
    {
        $this->mentions = $mentions;
    }

    public function getMentions()
    {
        return $this->mentions;
    }

    public function setMarkers($markers)
    {
        $this->markers = $markers;
    }

    public function getMarkers()
    {
        return $this->markers;
    }

    /**
     * Fetch marker categories from the DB
     */
    private function queryMarkerCategories()
    {
        $markerCategories = \DB::table('marker_categories')
            ->select('id', 'name', 'shorthand', 'is_default')
            ->where('user_id', $this->userId)
            ->get();

        return $markerCategories;
    }

    /**
     * Parse and collect tags from entry text
     * @return void
     */
    public function extractTags()
    {
        $tagAnnotation = new TagAnnotation();
        $tagAnnotation->setEntry($this->entryText);

        $this->setTags($tagAnnotation->extract());
    }

    /**
     * Parse and collect mentions from entry text
     * @return void
     */
    public function extractMentions()
    {
        $mentionAnnotation = new MentionAnnotation();
        $mentionAnnotation->setEntry($this->entryText);

        $this->setMentions($mentionAnnotation->extract());
    }

    /**
     * Parse and collect markers from entry text
     * @return void
     */
    public function extractMarkers()
    {
        $markerAnnotation = new MarkerAnnotation();
        $markerAnnotation->setEntry($this->entryText);

        $markers = $markerAnnotation->extract();
        $markerCategories = $this->queryMarkerCategories();

        $this->setMarkers($markerAnnotation->assignMarkersToCategories($markers, $markerCategories));
    }

    /**
     * Annotation parse driver
     * @return void
     */
    public function extract()
    {
        $this->extractTags();
        $this->extractMentions();
        $this->extractMarkers();
    }

    /**
     * Persist annotations
     * @return void
     */
    public function save()
    {
        foreach ($this->tags as $tag) {
            $persistedTag = Tag::firstOrCreate(['user_id' => $this->userId, 'name' => $tag]);
            EntryHasTag::create(['entry_id' => $this->entryId, 'tag_id' => $persistedTag->getAttribute('id')]);
        }

        foreach ($this->mentions as $mention) {
            $persistedMention = Mention::firstOrCreate(['user_id' => $this->userId, 'name' => $mention]);
            EntryHasMention::create(['entry_id' => $this->entryId, 'mention_id' => $persistedMention->getAttribute('id')]);
        }

        foreach ($this->markers as $markerCategory => $markers) {
            foreach ($markers as $marker) {
                $persistedMarker = Marker::firstOrCreate(['marker_category_id' => $markerCategory, 'entry_id' => $this->entryId, 'marker' => $marker]);
            }
        }
    }
}
