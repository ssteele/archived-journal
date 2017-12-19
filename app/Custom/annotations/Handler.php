<?php
namespace App\Custom\Annotations;

class Handler
{
    private $userId;
    private $entryId;
    private $entry;

    private $tags;
    private $mentions;
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

    public function setEntry($entry)
    {
        $this->entry = $entry;
    }

    public function getEntry()
    {
        return $this->entry;
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
            ->select('id', 'name', 'shorthand')
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
        $tagAnnotations = new TagAnnotations();
        $tagAnnotations->setEntry($this->entry);

        $this->setTags($tagAnnotations->extract());
    }

    /**
     * Parse and collect mentions from entry text
     * @return void
     */
    public function extractMentions()
    {
        $this->setMentions(['samplemention']);
    }

    /**
     * Parse and collect markers from entry text
     * @return void
     */
    public function extractMarkers()
    {
        // $markerCategories = $this->queryMarkerCategories();
        // foreach ($markerCategories as $markerCategory) {
        //     // pass
        // }

        // $this->setMarkers(['f' => 'sample feeling']);
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
        echo "<pre>this->tags: "; var_dump($this->tags); echo "</pre>\n";
        echo "<pre>this->mentions: "; var_dump($this->mentions); echo "</pre>\n";
        echo "<pre>this->markers: "; var_dump($this->markers); echo "</pre>\n";
    }
}
