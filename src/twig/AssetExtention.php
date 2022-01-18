<?php
namespace Blog\Twig;

use Psr\Http\Message\ServerRequestInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AssetExtention extends AbstractExtension
{
    private ServerRequestInterface $request;

    /**
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('asset_url', [$this, 'getAssetUrl']),
            new TwigFunction('url', [$this, 'getUrl']),
            new TwigFunction('base_url', [$this, 'getBaseUrl'])
        ];
    }

    /**
     * @param string $path
     * @return string
     */
    public function getAssetUrl(string $path):string
    {
        return $this->getBaseUrl() . $path;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        $params = $this->request->getServerParams();
        return $params['REQUEST_SCHEME'] . '://' . $params['HTTP_HOST'] . '/';
    }

    public function getUrl(string $path): string
    {
        return $this->getBaseUrl() . $path;
    }
}