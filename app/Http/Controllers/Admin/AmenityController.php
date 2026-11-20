<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AmenityController extends Controller
{
    /**
     * Display a listing of the amenities.
     */
    public function index(Request $request)
    {
        $query = Amenity::query();

        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where('name', 'LIKE', "%{$q}%");
        }

        $amenities = $query->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        $totalAmenities = Amenity::count();

        return view('admin.amenities.index', compact('amenities', 'totalAmenities'));
    }

    /**
     * Store a newly created amenity.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'file'],
        ], [
            'name.required' => 'Amenity name is required.',
        ]);

        $uploadDir = public_path('uploads/amenities');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $relativePath = '/uploads/amenities/auto-check.svg';
        $svgContent = file_exists(public_path('uploads/amenities/auto-check.svg'))
            ? file_get_contents(public_path('uploads/amenities/auto-check.svg'))
            : null;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');

            // Allow SVG, PNG, JPG, JPEG, WEBP, ICO
            if (!$this->isValidIconFile($file)) {
                return back()->withInput()->with('error', 'Only SVG files (.svg) are allowed for amenities icon.');
            }

            $cleanName = Str::slug($request->input('name'));
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . $cleanName . '.' . $ext;
            $file->move($uploadDir, $filename);

            $relativePath = '/uploads/amenities/' . $filename;
            // Store SVG content only for SVG files, sanitized to UTF-8
            $svgContent = ($ext === 'svg') ? $this->readSvgAsUtf8($uploadDir . '/' . $filename) : null;
            if ($svgContent) {
                file_put_contents($uploadDir . '/' . $filename, $svgContent);
            }
        }

        $maxOrder = (int) Amenity::max('order');

        $amenity = Amenity::create([
            'name'        => trim($request->input('name')),
            'slug'        => Str::slug($request->input('name')),
            'icon'        => $relativePath,
            'svg_content' => $svgContent,
            'order'       => $maxOrder + 1,
            'is_active'   => true,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Amenity created successfully.',
                'amenity' => $amenity,
            ]);
        }

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity "' . $amenity->name . '" added successfully.');
    }

    /**
     * Update the specified amenity.
     */
    public function update(Request $request, Amenity $amenity)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'file'],
        ]);

        $oldName = $amenity->name;
        $oldIcon = $amenity->icon;
        $amenity->name = trim($request->input('name'));
        $amenity->slug = Str::slug($amenity->name);

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            if (!$this->isValidIconFile($file)) {
                return back()->withInput()->with('error', 'Only SVG files (.svg) are allowed.');
            }

            $uploadDir = public_path('uploads/amenities');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Remove old file if exists (and not auto-check)
            if (!empty($amenity->icon) && !str_contains($amenity->icon, 'auto-check')) {
                $oldPath = public_path(ltrim($amenity->icon, '/'));
                if (file_exists($oldPath) && is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $cleanName = Str::slug($amenity->name);
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . $cleanName . '.' . $ext;
            $file->move($uploadDir, $filename);

            $amenity->icon = '/uploads/amenities/' . $filename;
            $amenity->svg_content = ($ext === 'svg') ? $this->readSvgAsUtf8($uploadDir . '/' . $filename) : null;
            if ($amenity->svg_content) {
                file_put_contents($uploadDir . '/' . $filename, $amenity->svg_content);
            }
        }

        $amenity->save();

        // Cascading sync to all page sections (highlights & amenities)
        $newName = $amenity->name;
        $newIcon = $amenity->icon;
        if ($oldName && ($oldName !== $newName || $oldIcon !== $newIcon)) {
            $sections = \App\Models\PageSection::whereIn('section_key', ['highlights', 'amenities'])->get();
            foreach ($sections as $sec) {
                $content = $sec->content;
                if (!is_array($content) || empty($content['items']) || !is_array($content['items'])) {
                    continue;
                }
                $changed = false;
                foreach ($content['items'] as &$it) {
                    if (!is_array($it)) continue;
                    $itName = $it['name'] ?? ($it['label'] ?? '');
                    $itIcon = $it['icon'] ?? '';
                    if (strcasecmp(trim($itName), trim($oldName)) === 0 || ($oldIcon && $itIcon === $oldIcon)) {
                        if (isset($it['name'])) $it['name'] = $newName;
                        if (isset($it['label'])) $it['label'] = $newName;
                        if ($newIcon) $it['icon'] = $newIcon;
                        $changed = true;
                    }
                }
                unset($it);
                if ($changed) {
                    $sec->update(['content' => $content]);
                }
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Amenity updated successfully.',
                'amenity' => $amenity,
            ]);
        }

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity "' . $amenity->name . '" updated successfully.');
    }

    /**
     * Remove the specified amenity.
     */
    public function destroy(Request $request, Amenity $amenity)
    {
        $name = $amenity->name;

        // Delete physical file (and not auto-check)
        if (!empty($amenity->icon) && !str_contains($amenity->icon, 'auto-check')) {
            $path = public_path(ltrim($amenity->icon, '/'));
            if (file_exists($path) && is_file($path)) {
                @unlink($path);
            }
        }

        $amenity->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Amenity "' . $name . '" deleted successfully.',
            ]);
        }

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity "' . $name . '" deleted successfully.');
    }

    /**
     * JSON listing endpoint for live CMS dropdown sync.
     */
    public function listJson()
    {
        $amenities = Amenity::orderBy('order', 'asc')->orderBy('name', 'asc')->get();
        return response()->json($amenities);
    }

    /**
     * Only genuine SVG files are allowed (.svg extension + <svg tag, UTF-16 safe).
     */
    private function isValidIconFile($file): bool
    {
        if (!$file || !$file->isValid()) {
            return false;
        }

        if (strtolower($file->getClientOriginalExtension()) !== 'svg') {
            return false;
        }

        $content = $this->readSvgAsUtf8($file->getRealPath());

        return $content !== null && stripos($content, '<svg') !== false;
    }

    /**
     * Read an SVG file and return clean UTF-8 string.
     * Handles UTF-16 LE/BE BOM, strips null bytes, re-encodes if needed.
     */
    private function readSvgAsUtf8(string $path): ?string
    {
        $raw = @file_get_contents($path);
        if (!$raw) return null;

        // Detect UTF-16 LE BOM (\xFF\xFE) or UTF-16 BE BOM (\xFE\xFF)
        if (substr($raw, 0, 2) === "\xFF\xFE") {
            $raw = mb_convert_encoding(substr($raw, 2), 'UTF-8', 'UTF-16LE');
        } elseif (substr($raw, 0, 2) === "\xFE\xFF") {
            $raw = mb_convert_encoding(substr($raw, 2), 'UTF-8', 'UTF-16BE');
        } elseif (substr($raw, 0, 3) === "\xEF\xBB\xBF") {
            // UTF-8 BOM — just strip BOM
            $raw = substr($raw, 3);
        }

        // Strip any remaining null bytes
        $raw = str_replace("\x00", '', $raw);

        // Ensure valid UTF-8; replace invalid sequences
        if (!mb_check_encoding($raw, 'UTF-8')) {
            $raw = mb_convert_encoding($raw, 'UTF-8', 'auto');
        }

        // Final null byte strip after conversion
        $raw = str_replace("\x00", '', $raw);

        return $raw ?: null;
    }
}
